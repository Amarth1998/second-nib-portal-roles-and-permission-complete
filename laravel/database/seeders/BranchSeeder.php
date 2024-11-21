<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert multiple branches into the 'branches' table
        DB::table('branches')->insert([
            [
                'name' => 'Bhopal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'jabalpur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Indore',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more branches as needed
        ]);
    }
}
