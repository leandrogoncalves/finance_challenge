<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransactionApiFeatureTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test of api method store from transaction controller
     */
    public function testStoreTransactionByApi()
    {
        $response = $this->post(route('api.transaction.store'),[
            'value' => 100,
            'payer' => 2,
            'payee' => 1,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure(['created']);

    }
}
