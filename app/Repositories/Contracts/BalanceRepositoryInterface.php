<?php


namespace App\Repositories\Contracts;


use Illuminate\Database\Eloquent\Model;

interface BalanceRepositoryInterface
{
    /**
     * @param array $data
     * @param int $id
     * @return Model
     */
    public function store(array $data):Model;
}
