<?php


namespace App\Services\Contracts;


use Illuminate\Database\Eloquent\Model;

interface TransactionServiceInterface
{
    /**
     * @param array $data
     * @return boolean
     */
    public function performTransaction(array $data):bool;
}
