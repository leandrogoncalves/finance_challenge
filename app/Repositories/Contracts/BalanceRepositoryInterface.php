<?php


namespace App\Repositories\Contracts;


use Illuminate\Database\Eloquent\Model;

interface BalanceRepositoryInterface
{
    /**
     * @param array $data
     * @return Model
     */
    public function store(array $data):Model;
}
