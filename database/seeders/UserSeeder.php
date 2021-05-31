<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
                'fullname' => 'Shop account',
                'email' => 'contact@shop.com',
                'cpf' => '97924414096',
                'wallet_id' => 1,
                'password' => bcrypt('secret')
            ],
            [
                'fullname' => 'Common account 01',
                'email' => 'account01@gmail.com',
                'cpf' => '63819531017',
                'wallet_id' => 2,
                'password' => bcrypt('secret')
            ],
            [
                'fullname' => 'Common account 02',
                'email' => 'account02@gmail.com',
                'cpf' => '60914716000',
                'wallet_id' => 3,
                'password' => bcrypt('secret')
            ],
        ])->each(function ($userStub){
            User::updateOrCreate(
                [
                    'cpf' => data_get($userStub, 'cpf')
                ],
                $userStub
            );
        });
    }
}
