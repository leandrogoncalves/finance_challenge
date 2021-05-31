<?php

namespace Tests\Unit;


use App\Models\Shop;
use App\Repositories\ShopRepository;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ShopRepositoryTest extends TestCase
{
    use DatabaseTransactions;


    /**
     * Test of api method store from shop repository
     */
    public function testStoreShopsByRepository()
    {
        $repository = app(ShopRepository::class);

        $shop = $repository->store([
            'name' => 'shop teste 1',
            'cnpj' => '12313221000131',
            'user_id' => 1,
        ]);

        $this->assertInstanceOf(Shop::class, $shop);
    }

    /**
     * Test of api method findById from shop repository
     */
    public function testShopsGetByIdRepository()
    {
        $repository = app(ShopRepository::class);

        $shop = $repository->findById(1);

        $this->assertInstanceOf(Shop::class, $shop);
    }

    /**
     * Test of api method index from shop repository
     */
    public function testUpdateShopsByRepository()
    {
        $repository = app(ShopRepository::class);

        $shop = $repository->store([
            "type" => "shop"
        ], 1);

        $this->assertInstanceOf(Shop::class, $shop);
    }

    /**
     * Test of api method delete from shop repository
     */
    public function testDeleteShopsByIdRepository()
    {
        $repository = app(ShopRepository::class);

        $isRemoved = $repository->delete(1);

        $this->assertTrue($isRemoved);
    }
}
