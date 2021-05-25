<?php


namespace App\Services\Contracts;


use Illuminate\Database\Eloquent\Model;

/**
 * Interface TransactionServiceInterface
 * @package App\Services\Contracts
 */
interface TransactionServiceInterface
{
    /**
     * @param array $data
     * @return boolean
     */
    public function performTransaction(array $data):bool;
}
