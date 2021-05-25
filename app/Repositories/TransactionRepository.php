<?php


namespace App\Repositories;


use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionRepository
 * @package App\Repositories
 */
class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * TransactionRepository constructor.
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @param int $id
     * @return Model
     */
    public function findById(int $id):Model
    {
        return $this->transaction::where('id', $id)->firstOrFail();
    }

    /**
     * @param array $data
     * @param null $id
     * @return Model
     */
    public function store(array $data, int $id = null):Model
    {
        if($id){
            $this->transaction = $this->findById($id);
        }

        $this->transaction->fill($data)->save();
        return $this->transaction;
    }

}
