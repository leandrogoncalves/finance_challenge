<?php

namespace Database\Seeders;

use App\Models\Balance;
use Illuminate\Database\Seeder;

class BalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'wallet_id' => 1,
                'value' => 1000,
            ],
            [
                'wallet_id' => 2,
                'value' => 2000,
            ],
            [
                'wallet_id' => 3,
                'value' => 3000,
            ],
            [
                'wallet_id' => 4,
                'value' => 4000,
            ],
        ])->each(function ($userStub){
            Balance::updateOrCreate($userStub);
        });
    }
}
