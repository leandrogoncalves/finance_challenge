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
                'type' => 'shop',
                'document' => '43830574000108',
                'email' => 'contact@shop.com',
                'password' => bcrypt('secret')
            ],
            [
                'fullname' => 'Common account 01',
                'type' => 'common',
                'document' => '63819531017',
                'email' => 'account01@gmail.com',
                'password' => bcrypt('secret')
            ],
            [
                'fullname' => 'Common account 02',
                'type' => 'common',
                'document' => '60914716000',
                'email' => 'account02@gmail.com',
                'password' => bcrypt('secret')
            ],
        ])->each(function ($userStub){
            User::updateOrCreate(
                [
                    'document' => data_get($userStub, 'document')
                ],
                $userStub
            );
        });
    }
}
