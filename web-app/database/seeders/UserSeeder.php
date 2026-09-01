<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a specific admin/test user
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'employee_id' => 'EMP001',
            'email' => 'john.doe@example.com',
            'phone' => '+1234567890',
            'password' => Hash::make('password123'),
            'birthday' => '1990-01-01',
        ]);

        // Create a second test user with different credentials
        User::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'employee_id' => 'EMP002',
            'email' => 'jane.smith@example.com',
            'phone' => '+0987654321',
            'password' => Hash::make('password123'),
            'birthday' => '1988-05-15',
        ]);

        // Create 10 additional random users using the factory
        User::factory(10)->create();

        // Create a user with specific employee_id
        User::factory()->withEmployeeId('EMP999')->create([
            'first_name' => 'Custom',
            'last_name' => 'User',
            'email' => 'custom@example.com',
        ]);

        // Create a user with a specific password
        User::factory()->withPassword('secret123')->create([
            'first_name' => 'Secure',
            'last_name' => 'User',
            'employee_id' => 'EMP888',
        ]);

        $this->command->info('Users seeded successfully!');
        $this->command->info('Test user: EMP001 / password123');
        $this->command->info('Test user: EMP002 / password123');
    }
}
