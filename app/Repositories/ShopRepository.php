<?php


namespace App\Repositories;


use App\Exceptions\NotFoundException;
use App\Models\Shop;
use App\Repositories\Contracts\ShopRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

class ShopRepository implements ShopRepositoryInterface
{
    protected $shop;

    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
    }

    /**
     * @return Arrayable
     */
    public function create(): Arrayable
    {
        return $this->shop;
    }

    /**
     * @param int $id
     * @return Model
     */
    public function findById(int $id): Model
    {
        $shop =  $this->shop->find($id);

        if(!$shop){
            throw new NotFoundException("Loja não encontrada");
        }

        return $shop;
    }

    /**
     * @param array $data
     * @param int|null $id
     * @return Model
     */
    public function store(array $data, int $id = null): Model
    {
        if($id){
            $this->shop = $this->findById($id);
        }
        $this->shop->fill($data)->save();
        return $this->shop;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $this->shop = $this->findById($id);
        return $this->shop->delete();
    }
}
