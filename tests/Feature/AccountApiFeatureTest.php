<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AccountApiFeatureTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test of api method index from account controller
     */
    public function testGetAllAccountByApi()
    {
        $response = $this->get(route('api.accounts.index'));

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'fullname',
                        'email',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                        'wallets'
                    ]
                ]
            ]);

    }

    /**
     * Test of api method store from account controller
     */
    public function testStoreAccountByApi()
    {
        $response = $this->post(route('api.accounts.store'),[
            'fullname' => 'Common account 05',
            'type' => 'common',
            'document' => '63819531019',
            'email' => 'account05@gmail.com',
            'password' => bcrypt('secret')
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'fullname',
                    'email',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'wallets'
                ]
            ]);

    }

    /**
     * Test of api method show from account controller
     */
    public function testGetAccountByIdApi()
    {
        $response = $this->get(route('api.accounts.show',1));

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'fullname',
                    'email',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'wallets'
                ]
            ]);

    }

    /**
     * Test of api method update from account controller
     */
    public function testUpdateAccountByApi()
    {
        $response = $this->put(route('api.accounts.update', 1),[
            "fullname" => "Teste update name ",
            "email" => "emailteste@teste.com.br"
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'fullname',
                    'email',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'wallets'
                ]
            ]);

    }

    /**
     * Test of api method delete from account controller
     */
    public function testDeleteAccountByIdApi()
    {
        $response = $this->delete(route('api.accounts.destroy',1));

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'removed'
            ]);

    }
}
