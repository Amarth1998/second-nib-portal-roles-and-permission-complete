<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class, // Seed roles and permissions
            SuperAdminSeeder::class,    // Seed Super Admin user
            AdminSeeder::class,          // Seed Admin user
            HrHeadSeeder::class,           // Seed User user
        ]);
    }
}
