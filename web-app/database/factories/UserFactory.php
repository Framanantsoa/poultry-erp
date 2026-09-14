<?php

namespace Database\Factories;

use App\Models\Auth\User;
use App\Services\SequenceService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    protected static ?string $password;

    protected ?SequenceService $seqService = null;

    /**
     * Inject the sequence service (optional setter).
     */
    public function withSequenceService(SequenceService $service): static
    {
        $this->seqService = $service;
        return $this;
    }

    /**
     * Lazily resolve the service if not injected.
     */
    protected function seqService(): SequenceService
    {
        return $this->seqService ??= app(SequenceService::class);
    }

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'employee_id' => $this->generateEmployeeId(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => $this->generatePhoneNumber(),
            'birthday' => fake()->dateTimeBetween('-45 years', '-20 years')->format('Y-m-d'),
            'password' => 'password123',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    protected function generateEmployeeId(): string
    {
        $number = $this->seqService()->next('emp_ID');
        return 'EMP' . str_pad((string) $number, 4, '0', STR_PAD_LEFT);
    }

    protected function generatePhoneNumber(): string
    {
        return '+261' . fake()->unique()->numberBetween(370000000, 379999999);
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