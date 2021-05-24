<?php

namespace Tests\Unit;

use App\Models\Balance;
use App\Repositories\BalanceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BalanceRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test of api method store from balance repository
     */
    public function testStoreBalancesByRepository()
    {
        $repository = app(BalanceRepository::class);

        $balance = $repository->store([
            'user_id' => 3,
            'value' => 1500.20,
        ]);

        $this->assertInstanceOf(Balance::class, $balance);
    }
}
