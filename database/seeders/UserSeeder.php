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
                'password' => bcrypt('secret')
            ],
            [
                'fullname' => 'Common account 01',
                'email' => 'account01@gmail.com',
                'password' => bcrypt('secret')
            ],
            [
                'fullname' => 'Common account 02',
                'email' => 'account02@gmail.com',
                'password' => bcrypt('secret')
            ],
        ])->each(function ($userStub){
            User::updateOrCreate(
                [
                    'email' => data_get($userStub, 'email')
                ],
                $userStub
            );
        });
    }
}
