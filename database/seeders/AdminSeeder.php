<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        \DB::table('admins')->insert([
            [
                'id' => 1,
                'username'=> 'anhvt',
                'email' => 'theanhvu06@gmail.com',
                'password' => Hash::make('123456789'),
                'phone' => '0999990000',
                'role_id' => 1,
                'birthday'=> '2022-09-22'
            ]
        ]);
    }
}
