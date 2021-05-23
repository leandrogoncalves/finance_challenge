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
                'user_id' => 1,
                'value' => 1000,
            ],
            [
                'user_id' => 2,
                'value' => 2000,
            ],
            [
                'user_id' => 3,
                'value' => 3000,
            ],
        ])->each(function ($userStub){
            Balance::updateOrCreate($userStub);
        });
    }
}
