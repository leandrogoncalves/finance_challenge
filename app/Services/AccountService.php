<?php


namespace App\Services;


use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\WalletRepositoryInterface;
use App\Services\Contracts\AccountServiceInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountService
 * @package App\Services
 */
class AccountService implements AccountServiceInterface
{
    protected $userRespository;

    protected $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository, UserRepositoryInterface $userRepository)
    {
        $this->walletRepository = $walletRepository;
        $this->userRespository = $userRepository;
    }

    /**
     * @return Arrayable
     */
    public function findAllPaginated(): Arrayable
    {
        return $this->userRespository->findAllPaginated(['wallets.current_balance']);
    }

    /**
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model
    {
        return $this->userRespository->findById($id, [
            'wallets.current_balance',
            'wallets.inbound_transactions',
            'wallets.outgoing_transactions'
        ]);
    }

    /**
     * @param array $data
     * @param int|null $id
     * @return Model
     */
    public function store(array $data, int $id = null): Model
    {
        $document = data_get($data, 'document');
        $user = $this->userRespository->create();
        $wallet = null;

        if($id){
           $user = $this->userRespository->findById($id, ['wallets']);
        }

        $user->fill($data)->save();

        if($document){
            $wallet = $user->wallets->where('document',$document)->first();
            if(!$wallet){
                $wallet = $this->walletRepository->create();
            }
            data_set($data, 'user_id', $user->id);
            $wallet->fill($data)->save();
        }

        return $this->userRespository->findById($user->id, ['wallets']) ;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $user = $this->userRespository->findById($id, ['wallets']);
        $user->wallets->each(function ($wallet){
            $wallet->delete();
        });
        return $user->delete();
    }
}
