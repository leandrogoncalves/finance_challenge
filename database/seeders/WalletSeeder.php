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
                'type' => 'common',
            ],[
                'type' => 'common',
            ],[
                'type' => 'common',
            ],[
                'type' => 'shop',
            ],
        ])->each(function ($walletStub){
            Wallet::create( $walletStub);
        });
    }
}
