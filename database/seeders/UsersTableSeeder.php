<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'fullname' => 'usman',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('1122') ,
                'role' => 'admin',
                'status' => 'active'
            ],
            [
                'fullname' => 'usman',
                'username' => 'vendor',
                'email' => 'vendor@gmail.com',
                'password' => Hash::make('1122') ,
                'role' => 'vendor',
                'status' => 'active'
            ],
            [
                'fullname' => 'usman',
                'username' => 'customer',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('1122') ,
                'role' => 'customer',
                'status' => 'active'
            ],
        ]);
    }
}
