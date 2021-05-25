<?php


namespace App\Repositories;


use App\Exceptions\NotFoundException;
use App\Models\Wallet;
use App\Repositories\Contracts\WalletRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WalletRepository
 * @package App\Repositories
 */
class WalletRepository implements WalletRepositoryInterface
{
    /**
     * @var Wallet
     */
    protected $wallet;

    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * @return Arrayable
     */
    public function create(): Arrayable
    {
        return $this->wallet;
    }


    /**
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model
    {
        $wallet =  $this->wallet->find($id);

        if(!$wallet){
            throw new NotFoundException("Carteira não encontrada");
        }

        return $wallet;
    }

    /**
     * @param array $data
     * @param int|null $id
     * @return Model
     */
    public function store(array $data, int $id = null): Model
    {
        if($id){
            $this->wallet = $this->findById($id);
        }
        $this->wallet->fill($data)->save();
        return $this->wallet;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $this->wallet = $this->findById($id);
        return $this->wallet->delete();
    }
}
