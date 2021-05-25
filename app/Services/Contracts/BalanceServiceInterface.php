<?php


namespace App\Services\Contracts;


use Illuminate\Database\Eloquent\Model;

/**
 * Interface BalanceServiceInterface
 * @package App\Services\Contracts
 */
interface BalanceServiceInterface
{
    /**
     * @param int $transactionId
     * @param int $userId
     * @param float $value
     * @return Model
     */
    public function create(int $transactionId,int $userId, float $value):Model;
}
