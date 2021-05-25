<?php


namespace App\Repositories;


use App\Models\Balance;
use App\Repositories\Contracts\BalanceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BalanceRepository
 * @package App\Repositories
 */
class BalanceRepository implements BalanceRepositoryInterface
{
    /**
     * @var Balance
     */
    private $balance;

    /**
     * BalanceRepository constructor.
     * @param Balance $balance
     */
    public function __construct(Balance $balance)
    {
        $this->balance = $balance;
    }

    /**
     * @param array $data
     * @param null $id
     * @return Model
     */
    public function store(array $data):Model
    {
        $newBalance = new Balance();
        $newBalance->fill($data)->save();
        return $newBalance;
    }

}
