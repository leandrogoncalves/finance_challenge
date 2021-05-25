<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * Test of payment notification
     */
    public function testPaymentNotificationByService()
    {
        $service = app(NotificationService::class);

        $user = 1;
        $value = 100;

        $transaction = new Transaction([
            'payer' => 2,
            'payee' => $user,
            'value' => $value
        ]);

        $result = $service->notifyTransaction($transaction);

        $this->assertTrue($result);
    }
}
