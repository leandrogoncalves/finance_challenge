<?php


namespace App\Services;


use App\Exceptions\TransactionException;
use App\Jobs\ProcessTransationNotification;
use App\Models\States;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Contracts\BalanceRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\BalanceServiceInterface;
use App\Services\Contracts\PaymentAuthorizationInterface;
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

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;
    /**
     * @var BalanceServiceInterface
     */
    protected $balanceService;
    /**
     * @var TransactionRepositoryInterface
     */
    protected $transactionRepository;

    /**
     * @var PaymentAuthorizationInterface
     */
    protected $paymentAuthorizationService;

    /**
     * @var User
     */
    protected $payee;

    /**
     * @var User
     */
    protected $payer;

    /**
     * @var float
     */
    protected $transactionValue;

    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * TransactionService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param BalanceRepositoryInterface $balanceRepository
     * @param TransactionRepositoryInterface $transactionRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        BalanceServiceInterface $balanceService,
        TransactionRepositoryInterface $transactionRepository,
        PaymentAuthorizationInterface $paymentAuthorization
    )
    {
        $this->userRepository = $userRepository;
        $this->balanceService = $balanceService;
        $this->transactionRepository = $transactionRepository;
        $this->paymentAuthorizationService = $paymentAuthorization;
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

        $this->payer = $this->userRepository->findById(data_get($data, 'payer'));
        $this->payee = $this->userRepository->findById(data_get($data, 'payee'));
        $this->transactionValue = (float) data_get($data, 'value');

        $this->checkPositiveValue()
            ->checkBalanceEnough()
            ->checkPayerAccountType()
            ->setTrasactionPending()
            ->checkTransactionAuthorization();

        try {
            DB::beginTransaction();

            //New peyer balance
            $this->balanceService->create(
                $this->transaction->id,
                $this->payer->id,
                (float) $this->payer->current_balance->value - (float) $this->transaction->value
            );

            //New peyee balance
            $this->balanceService->create(
                $this->transaction->id,
                $this->payee->id,
                (float) $this->payee->current_balance->value + (float) $this->transaction->value
            );

            $this->setTransactionComplete();

            DB::commit();

            ProcessTransationNotification::dispatch($this->transaction)->onQueue('notifications');

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
     * @return $this|TransactionServiceInterface
     * @throws TransactionException
     */
    public function checkPositiveValue():TransactionServiceInterface
    {
        if($this->transactionValue <= 0){
            throw new TransactionException('O valor da transação precisa ser maior que zero');
        }

        return $this;
    }

    /**
     * @return $this|TransactionServiceInterface
     * @throws TransactionException
     */
    public function checkBalanceEnough():TransactionServiceInterface
    {
        if(!$this->payee->current_balance){
            $this->balanceRepository->store([
                'value'   => 0,
                'user_id' => $this->payee->id
            ]);
        }

        if(!$this->payer->current_balance
            || $this->payer->current_balance->value <= 0
            || $this->payer->current_balance->value < $this->transactionValue
        ){
            throw new TransactionException('Saldo insuficiente');
        }

        return $this;
    }

    /**
     * @return TransactionServiceInterface
     * @throws TransactionException
     */
    public function checkPayerAccountType():TransactionServiceInterface
    {
        if($this->payer->isShopAccount()){
            throw new TransactionException('A conta de logista não pode realizar transferências');
        }

        return $this;
    }

    /**
     * set Transaction Denied
     */
    public function setTransactionDenied():void
    {
        $this->transactionRepository->store([
            'status' => 'denied'
        ], $this->transaction->id);
    }

    /**
     * @return $this|TransactionServiceInterface
     */
    public function setTrasactionPending():TransactionServiceInterface
    {
        //New transaction pending
        $this->transaction = $this->transactionRepository->store([
            'payer' => $this->payer->id,
            'payee' => $this->payee->id,
            'value' => $this->transactionValue
        ]);

        return $this;
    }

    /**
     * @throws TransactionException
     */
    public function checkTransactionAuthorization():void
    {
        if(!$this->paymentAuthorizationService->isAuthorized($this->transaction)){
            $this->setTransactionDenied();
            throw new TransactionException('Transação negada');
        }
    }

    /**
     * set Transaction Complete
     */
    public function setTransactionComplete():void
    {
        $this->transactionRepository->store([
            'status' => 'complete'
        ], $this->transaction->id);
    }

}
