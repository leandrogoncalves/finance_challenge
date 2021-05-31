<?php


namespace App\Repositories\Contracts;


use Illuminate\Database\Eloquent\Model;

interface ShopRepositoryInterface
{

    /**
     * @param int $id
     * @return Model
     */
    public function findById(int $id):Model;

    /**
     * @param array $data
     * @param int $id
     * @return Model
     */
    public function store(array $data, int $id = null):Model;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id):bool;
}
