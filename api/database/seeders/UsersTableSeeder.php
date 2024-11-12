<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'firstName' => 'admin',
            'lastName' => 'one',
            'userName' => 'admin',
            'email' => 'SupplyEase@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'), // Use a secure password here
            'userTypeID' => 1, // 1 corresponds to "Administrator" type
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}