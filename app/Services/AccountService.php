<?php


namespace App\Services;


use App\Models\Shop;
use App\Models\User;
use App\Repositories\Contracts\ShopRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\WalletRepositoryInterface;
use App\Services\Contracts\AccountServiceInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

/**
 * Class AccountService
 * @package App\Services
 */
class AccountService implements AccountServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRespository;

    /**
     * @var WalletRepositoryInterface
     */
    protected $walletRepository;

    /**
     * @var ShopRepositoryInterface
     */
    protected $shopRepository;

    /**
     * @var User
     */
    protected $user;

    /**
     * AccountService constructor.
     * @param WalletRepositoryInterface $walletRepository
     * @param UserRepositoryInterface $userRepository
     * @param ShopRepositoryInterface $shopRepository
     */
    public function __construct(
        WalletRepositoryInterface $walletRepository,
        UserRepositoryInterface $userRepository,
        ShopRepositoryInterface $shopRepository
    )
    {
        $this->walletRepository = $walletRepository;
        $this->userRespository = $userRepository;
        $this->shopRepository = $shopRepository;
    }

    /**
     * @return Arrayable
     */
    public function findAllPaginated(): Arrayable
    {
        return $this->userRespository->findAllPaginated(['wallet.current_balance', 'shops.wallet.current_balance']);
    }

    /**
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model
    {
        return $this->userRespository->findById($id, [
            'wallet.current_balance',
            'wallet.inbound_transactions',
            'wallet.outgoing_transactions',
            'shops.wallet.current_balance'
        ]);
    }

    /**
     * @param array $requestData
     * @param int|null $id
     * @return Model
     */
    public function store(array $requestData, int $id = null): Model
    {
        $cnpj = data_get($requestData, 'cnpj');
        $this->user = $this->userRespository->store($requestData, $id);

        $this->storeUserWallet($requestData);
        if($cnpj){
            $this->storeShop($requestData);
        }
        return $this->userRespository->findById($this->user->id, ['wallet','shops.wallet']) ;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $user = $this->userRespository->findById($id, ['wallet']);
        $user->shops->each(function ($shop){
            $shop->wallet->delete();
            $shop->delete();
        });
        return $user->delete();
    }

    /**
     * @param array $requestData
     * @return Model
     */
    protected function storeUserWallet(array $requestData):Model
    {
        $idWallet = null;
        $wallet = $this->user->wallet;
        if($wallet){
            return $this->walletRepository->store($requestData, $wallet->id);
        }
        data_set($requestData, 'type', 'common');

        $wallet = $this->walletRepository->store([
            'type' => 'common'
        ]);

        $this->userRespository->store([
            'wallet_id' => $wallet->id
        ], $this->user->id);

        return $wallet;
    }

    /**
     * @param array $requestData
     * @return Model
     */
    protected function storeShop(array $requestData):Model
    {
        $shopName = data_get($requestData, 'shop_name', 'shop_'.Uuid::uuid4());
        data_set($requestData, 'name', $shopName);
        $shopId = null;
        $shop = $this->user->shop;
        if($shop){
            return $this->shopRepository->store($requestData, $shop->id);
        }

        data_set($requestData, 'user_id', $this->user->id);
        $shop = $this->shopRepository->store($requestData);

        $this->storeShopWallet($shop);
        return $shop;
    }

    /**
     * @param Shop $shop
     */
    protected function storeShopWallet(Shop $shop):void
    {
        $wallet = $shop->wallet;
        if(!$wallet){
            $wallet = $this->walletRepository->store([
                'type' => 'shop'
            ]);
            $this->shopRepository->store([
                'wallet_id' => $wallet->id
            ], $shop->id);
        }
    }
}
