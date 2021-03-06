<?php


namespace App\Repositories\Contracts;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface UserRepositoryInterface
 * @package App\Repositories\Contracts
 */
interface UserRepositoryInterface
{
    /**
     * @param array|null $with
     * @return Arrayable
     */
    public function findAll(array $with = null):Arrayable;

    /**
     * @param array|null $with
     * @return mixed
     */
    public function findAllPaginated(array $with = null);

    /**
     * @param int $id
     * @param array|null $with
     * @return Model
     */
    public function findById(int $id, array $with = null):Model;

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
