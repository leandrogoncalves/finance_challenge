<?php


namespace App\Services;


use App\Repositories\Contracts\BalanceRepositoryInterface;
use App\Services\Contracts\BalanceServiceInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BalanceService
 * @package App\Services
 */
class BalanceService implements BalanceServiceInterface
{
    /**
     * @var BalanceRepositoryInterface
     */
    protected $balanceRepository;

    /**
     * BalanceService constructor.
     * @param BalanceRepositoryInterface $balanceRepository
     */
    public function __construct(BalanceRepositoryInterface $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    /**
     * @param int $transactionId
     * @param int $userId
     * @param float $value
     * @return Model
     */
    public function create(int $transactionId,int $userId, float $value):Model
    {
        return $this->balanceRepository->store([
            'transaction_id' => $transactionId,
            'user_id'        => $userId,
            'value'          => $value
        ]);
    }
}
