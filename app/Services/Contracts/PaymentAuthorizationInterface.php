<?php


namespace App\Services\Contracts;


use App\Models\Transaction;

/**
 * Interface PaymentAuthorizationInterface
 * @package App\Services\Contracts
 */
interface PaymentAuthorizationInterface
{
    /**
     * @param Transaction $transaction
     * @return bool
     */
    public function isAuthorized(Transaction  $transaction):bool;
}
