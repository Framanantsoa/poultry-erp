<?php

namespace Database\Seeders;

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    // Create 10 random users using the factory
        User::factory(10)->create();

        $this->command->info('Users seeded successfully!');
    }
}
