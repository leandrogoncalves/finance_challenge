<?php


namespace App\Repositories\Contracts;


use Illuminate\Database\Eloquent\Model;

interface TransactionRepositoryInterface
{
    /**
     * @param array $data
     * @param int $id
     * @return Model
     */
    public function store(array $data, int $id = null):Model;
}
