<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
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
                'name' => "shop test 1",
                'wallet_id' => 4,
                'cnpj' => '43830574000108',
            ]
        ])->each(function ($shopStub){
            Shop::updateOrCreate(
                [
                    'cnpj' => data_get($shopStub, 'cnpj')
                ],
                $shopStub
            );
        });
    }
}
