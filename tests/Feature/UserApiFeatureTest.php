<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserApiFeatureTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test of api method index from user controller
     */
    public function testGetAllUsersByApi()
    {
        $response = $this->get(route('api.users.index'));

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'fullname',
                        'type',
                        'document',
                        'email',
                        'email_verified_at',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                        'current_balance',
                    ]
                ]
            ]);

    }

    /**
     * Test of api method store from user controller
     */
    public function testStoreUsersByApi()
    {
        $response = $this->post(route('api.users.store'),[
            'fullname' => 'Common account 05',
            'type' => 'common',
            'document' => '63819531019',
            'email' => 'account05@gmail.com',
            'password' => bcrypt('secret')
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'fullname',
                    'type',
                    'document',
                    'email',
                    'created_at',
                    'updated_at',
                ]
            ]);

    }

    /**
     * Test of api method show from user controller
     */
    public function testGetUsersByIdApi()
    {
        $response = $this->get(route('api.users.show',1));

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'fullname',
                    'type',
                    'document',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'current_balance',
                ]
            ]);

    }

    /**
     * Test of api method update from user controller
     */
    public function testUpdateUsersByApi()
    {
        $response = $this->put(route('api.users.update', 1),[
            "name" => "Sabote com marca ",
            "quantity" => 5
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'fullname',
                    'type',
                    'document',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'current_balance',
                ]
            ]);

    }

    /**
     * Test of api method delete from user controller
     */
    public function testDeleteUsersByIdApi()
    {
        $response = $this->delete(route('api.users.destroy',1));

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'removed'
            ]);

    }
}
