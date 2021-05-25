<?php


namespace App\Services\Contracts;


use App\Models\Transaction;

/**
 * Interface NotificationServiceInterface
 * @package App\Services\Contracts
 */
interface NotificationServiceInterface
{
    /**
     * @param Transaction $transaction
     * @return mixed
     */
    public function notifyTransaction(Transaction $transaction);
}
