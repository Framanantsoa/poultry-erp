<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        
        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'employee_id' => 'EMP' . fake()->unique()->numberBetween(1000, 9999),
            'email' => fake()->unique()->safeEmail(),
            'phone' => $this->generatePhoneNumber(), // Use custom method
            'birthday' => fake()->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'password' => static::$password ??= Hash::make('password123'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Generate a valid phone number (max 15 characters).
     */
    private function generatePhoneNumber(): string
    {
        // Generate a simple 10-digit number without formatting
        return '0' . fake()->unique()->numberBetween(600000000, 799999999);
        
        // Or generate with country code (max 15 chars)
        // return fake()->unique()->numerify('+261## ### ####'); // Madagascar format
        // return fake()->unique()->numerify('+1##########'); // US format (10 digits)
        // return fake()->unique()->numerify('+33#########'); // France format
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => null,
        ]);
    }

    /**
     * Create a user with specific employee_id.
     */
    public function withEmployeeId(string $employeeId): static
    {
        return $this->state(fn (array $attributes) => [
            'employee_id' => $employeeId,
        ]);
    }

    /**
     * Create a user with specific first and last name.
     */
    public function withName(string $firstName, string $lastName): static
    {
        return $this->state(fn (array $attributes) => [
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);
    }

    /**
     * Create a user with specific password.
     */
    public function withPassword(string $password): static
    {
        return $this->state(fn (array $attributes) => [
            'password' => Hash::make($password),
        ]);
    }
}