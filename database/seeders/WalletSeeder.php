<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
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
                'type' => 'shop',
                'document' => '43830574000108',
            ],[
                'user_id' => 2,
                'type' => 'common',
                'document' => '63819531017',
            ],[
                'user_id' => 3,
                'type' => 'common',
                'document' => '60914716000',
            ],
        ])->each(function ($walletStub){
            Wallet::updateOrCreate(
                [
                    'user_id' => data_get($walletStub, 'user_id')
                ],
                $walletStub
            );
        });
    }
}
