<?php


namespace App\Services;


use App\Exceptions\TransactionException;
use App\Jobs\ProcessTransationNotification;
use App\Models\States;
use App\Models\Transaction;
use App\Repositories\Contracts\BalanceRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\TransactionServiceInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class TransactionService
 * @package App\Services
 */
class TransactionService implements TransactionServiceInterface
{
    const apiAuthorizationBaseUri = 'https://run.mocky.io/';
    const apiAuthorizationResourceUri = 'v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;
    /**
     * @var BalanceRepositoryInterface
     */
    protected $balanceRepository;
    /**
     * @var TransactionRepositoryInterface
     */
    protected $transactionRepository;

    /**
     * TransactionService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param BalanceRepositoryInterface $balanceRepository
     * @param TransactionRepositoryInterface $transactionRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        BalanceRepositoryInterface $balanceRepository,
        TransactionRepositoryInterface $transactionRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->balanceRepository = $balanceRepository;
        $this->transactionRepository = $transactionRepository;
    }


    /**
     * @param array $data
     * @return bool
     */
    public function performTransaction(array $data):bool
    {
        if(data_get($data, 'payer') === data_get($data, 'payee')){
            throw new TransactionException('Não é possível realizar transações para a conta de origem');
        }

        $payer = $this->userRepository->findById(data_get($data, 'payer'));
        $payee = $this->userRepository->findById(data_get($data, 'payee'));
        $value = (float) data_get($data, 'value');

        if(!$payer->current_balance || $payer->current_balance->value <= 0){
            throw new TransactionException('Saldo insuficiente');
        }

        if(!$payee->current_balance){
            $this->balanceRepository->store([
                'value'   => 0,
                'user_id' => $payee->id
            ]);
        }

        if($payer->isShopAccount()){
            throw new TransactionException('A conta de logista não pode realizar transferências');
        }

        //New transaction pending
        $transaction = $this->transactionRepository->store([
            'payer' => $payer->id,
            'payee' => $payee->id,
            'value' => $value
        ]);

        if(!$this->isAuthorized()){
            $transaction->status = 'denied';
            $transaction->save();
            throw new TransactionException('Transação negada');
        }

        try {
            DB::beginTransaction();

            //New peyer balance
            $this->balanceRepository->store([
                'value'   => (float) $payer->current_balance->value - (float) $transaction->value,
                'user_id' => $payer->id
            ]);

            //New peyee balance
            $this->balanceRepository->store([
                'value'   => (float) $payer->current_balance->value + (float) $transaction->value,
                'user_id' => $payee->id
            ]);

            DB::commit();

            $this->sendNotification($transaction);
            return true;
        }catch (\Exception $e){
            Log::error($e->getMessage(). ' - '.$e->getFile().':'.$e->getLine());
            try{
                DB::rollBack();
            }catch (\Exception $ex){
                Log::error($ex->getMessage(). ' - '.$ex->getFile().':'.$ex->getLine());
            }
            throw new TransactionException('Erro ao completar a transação, entre em contato com o suporte. Código de erro: #5128');
        }
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isAuthorized():bool
    {
        $output = false;

        try{
            $client = new Client(['base_uri' => self::apiAuthorizationBaseUri]);

            $response = $client->get(self::apiAuthorizationResourceUri);
            $states = json_decode($response->getBody()->getContents());

           if(data_get($states, 'message') === 'Autorizado'){
                $output = true;
           }

        } catch (\Exception $e){
            Log::error($e->getMessage());
        }

        return $output;
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendNotification(Transaction $transaction):void
    {
        //Send notification to queue
        ProcessTransationNotification::dispatch($transaction)->onQueue('notifications');
    }
}
