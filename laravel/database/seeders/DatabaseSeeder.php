<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class, // Seed roles and permissions
           
            AdminSeeder::class,          // Seed Admin user
          
        ]);
    }
}
