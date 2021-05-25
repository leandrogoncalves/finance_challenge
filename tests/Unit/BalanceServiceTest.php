<?php

namespace Tests\Unit;

use App\Models\Balance;
use App\Models\Transaction;
use App\Services\BalanceService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BalanceServiceTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Test of creating new balance
     */
    public function testCreateNewBalanceByService()
    {
        $service = app(BalanceService::class);

        $payer = 2;
        $payee = 1;
        $value = 100;
        $currentBalance = 1000;

        $transaction = new Transaction();
        $transaction->fill([
            'payer' => $payer,
            'payee' => $payee,
            'value' => $value
        ])->save();

        $balance = $service->create($transaction->id, $payee, $currentBalance+$value);

        $this->assertInstanceOf(Balance::class,  $balance);
    }
}
