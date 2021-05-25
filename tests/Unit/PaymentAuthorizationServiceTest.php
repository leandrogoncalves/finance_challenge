<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Services\PaymentAutorizationService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PaymentAuthorizationServiceTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Test of payment authorization
     */
    public function testPaymentAuthorizationByService()
    {
        $service = app(PaymentAutorizationService::class);

        $transaction = new Transaction([
            'payer' => 2,
            'payee' => 1,
            'value' => 100
        ]);

        $isTransactionSuccessfull = $service->isAuthorized($transaction);

        $this->assertTrue($isTransactionSuccessfull);
    }
}
