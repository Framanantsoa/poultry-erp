<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call your seeder classes
        $this->call([
            UserSeeder::class,
            // Add other seeders here
            // RoleSeeder::class,
            // PermissionSeeder::class,
        ]);

        // Or create a single test user directly
        // \App\Models\User::factory()->create([
        //     'first_name' => 'Test',
        //     'last_name' => 'User',
        //     'employee_id' => 'EMP999',
        //     'email' => 'test@example.com',
        //     'phone' => '1234567890',
        //     'password' => bcrypt('password123'),
        // ]);
    }
}