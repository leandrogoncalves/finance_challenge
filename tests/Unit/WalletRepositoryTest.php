<?php

namespace Tests\Unit;

use App\Models\Wallet;
use App\Repositories\Contracts\WalletRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WalletRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test of api method store from wallet repository
     */
    public function testStoreWalletsByRepository()
    {
        $repository = app(WalletRepositoryInterface::class);

        $wallet = $repository->store([
            'type' => 'common',
            'document' => '63819531018',
            'user_id' => 1,
        ]);

        $this->assertInstanceOf(Wallet::class, $wallet);
    }

    /**
     * Test of api method findById from wallet repository
     */
    public function testWalletsGetByIdRepository()
    {
        $repository = app(WalletRepositoryInterface::class);

        $wallet = $repository->findById(1);

        $this->assertInstanceOf(Wallet::class, $wallet);
    }

    /**
     * Test of api method update from wallet repository
     */
    public function testUpdateWalletsByRepository()
    {
        $repository = app(WalletRepositoryInterface::class);

        $wallet = $repository->store([
            "document" => "1132131316516",
            "type" => "shop"
        ], 1);

        $this->assertInstanceOf(Wallet::class, $wallet);
    }

    /**
     * Test of api method delete from wallet repository
     */
    public function testDeleteWalletsByIdRepository()
    {
        $repository = app(WalletRepositoryInterface::class);

        $isRemoved = $repository->delete(1);

        $this->assertTrue($isRemoved);
    }
}
