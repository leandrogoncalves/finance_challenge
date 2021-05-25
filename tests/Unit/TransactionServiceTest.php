<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test of api method performTransaction from transaction service
     */
    public function testPerformTransactionsByService()
    {
        $service = app(TransactionService::class);

        $isTransactionSuccessfull = $service->performTransaction([
            'payer' => 2,
            'payee' => 1,
            'value' => 100.50,
        ]);

        $this->assertTrue($isTransactionSuccessfull);
    }

}
