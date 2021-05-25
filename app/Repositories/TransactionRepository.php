<?php


namespace App\Repositories;


use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * @var Transaction
     */
    private $model;

    /**
     * TransactionRepository constructor.
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->model = $transaction;
    }

    public function findById(int $id):Model
    {
        return $this->model::where('id', $id)->firstOrFail();
    }

    /**
     * @param array $data
     * @param null $id
     * @return Model
     */
    public function store(array $data, int $id = null):Model
    {
        if($id){
            $this->model = $this->findById($id);
        }

        $this->model->fill($data)->save();
        return $this->model;
    }

}
