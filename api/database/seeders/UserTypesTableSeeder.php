<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the table is empty before seeding
        Schema::disableForeignKeyConstraints();
        DB::table('userTypes')->truncate();
        Schema::enableForeignKeyConstraints();

        $userTypes = [
            ['userTypeName' => 'Administrator'],
            ['userTypeName' => 'Customer'],
            ['userTypeName' => 'Supplier'],
            ['userTypeName' => 'Staff'],
        ];

        foreach ($userTypes as $userType) {
            DB::table('userTypes')->insert([
                'userTypeName' => $userType['userTypeName']
            ]);
        }
    }
}
