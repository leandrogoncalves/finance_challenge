<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\Contracts\AccountServiceInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AccountServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test of api method findAllPaginated from account service
     */
    public function testGetAllAccountsByRepository()
    {
        $service = app(AccountServiceInterface::class);

        $collection = $service->findAllPaginated();

        $this->assertInstanceOf(Arrayable::class, $collection);
    }

    /**
     * Test of api method store from account service
     */
    public function testStoreAccountsByRepository()
    {
        $service = app(AccountServiceInterface::class);

        $account = $service->store([
            'fullname' => 'Common account 03',
            "type" => "common",
            "document" => "12345678905",
            'email' => 'account03@gmail.com',
            'password' => bcrypt('secret')
        ]);

        $this->assertInstanceOf(User::class, $account);
    }

    /**
     * Test of api method findById from account service
     */
    public function testAccountsGetByIdRepository()
    {
        $service = app(AccountServiceInterface::class);

        $account = $service->findById(1);

        $this->assertInstanceOf(User::class, $account);
    }

    /**
     * Test of api method update from account service
     */
    public function testUpdateAccountsByRepository()
    {
        $service = app(AccountServiceInterface::class);

        $account = $service->store([
            "fullname" => "Shop account 03",
            "type" => "shop"
        ], 1);

        $this->assertInstanceOf(User::class, $account);
    }

    /**
     * Test of api method delete from account service
     */
    public function testDeleteAccountsByIdRepository()
    {
        $service = app(AccountServiceInterface::class);

        $isRemoved = $service->delete(1);

        $this->assertTrue($isRemoved);
    }
}
