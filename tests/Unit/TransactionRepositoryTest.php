<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransactionRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test of api method store from transaction repository
     */
    public function testStoreTransactionsByRepository()
    {
        $repository = app(TransactionRepository::class);

        $transaction = $repository->store([
            'payer' => 2,
            'payee' => 1,
            'value' => 100.50,
        ]);

        $this->assertInstanceOf(Transaction::class, $transaction);
    }
}
