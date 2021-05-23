<?php


namespace App\Repositories\Contracts;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryInterface
 * @package App\Repositories\Contracts
 */
interface RepositoryInterface
{
    /**
     * @return Arrayable
     */
    public function findAll():Arrayable;

    /**
     * @return mixed
     */
    public function findAllPaginated();

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
