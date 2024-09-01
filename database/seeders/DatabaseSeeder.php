<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Account::create([
                'username' => $faker->username(),
                'email' => $faker->email(),
                'password' => $faker->password(),
                'acc_type_ID' => $faker->numberBetween(1,100)
            ]);
        }
    }
}
