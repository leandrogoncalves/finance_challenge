<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test of api method findAll from user repository
     */
    public function testGetAllUsersByRepository()
    {
        $repository = app(UserRepository::class);

        $collection = $repository->findAll();

        $this->assertInstanceOf(Arrayable::class, $collection);
    }

    /**
     * Test of api method store from user repository
     */
    public function testStoreUsersByRepository()
    {
        $repository = app(UserRepository::class);

        $user = $repository->store([
            'fullname' => 'Common account 03',
            'email' => 'account03@gmail.com',
            'password' => bcrypt('secret')
        ]);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * Test of api method findById from user repository
     */
    public function testUsersGetByIdRepository()
    {
        $repository = app(UserRepository::class);

        $user = $repository->findById(1);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * Test of api method index from user repository
     */
    public function testUpdateUsersByRepository()
    {
        $repository = app(UserRepository::class);

        $user = $repository->store([
            "fullname" => "Shop account 03",
            "type" => "shop"
        ], 1);

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * Test of api method delete from user repository
     */
    public function testDeleteUsersByIdRepository()
    {
        $repository = app(UserRepository::class);

        $isRemoved = $repository->delete(1);

        $this->assertTrue($isRemoved);
    }
}
