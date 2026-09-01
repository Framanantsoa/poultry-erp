<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Attempt to log in a user with employee_id and password.
     *
     * @param string $employeeId
     * @param string $password
     * @return User
     * @throws ValidationException
     */
    public function login(string $employeeId, string $password): User
    {
        // Find user by employee_id
        $user = User::where('employee_id', $employeeId)->first();

        // Check if user exists and password matches
        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'employee_id' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Attempt to log in (this will set the session)
        if (!Auth::attempt(['employee_id' => $employeeId, 'password' => $password])) {
            throw ValidationException::withMessages([
                'employee_id' => ['Authentication failed.'],
            ]);
        }

        // Regenerate session to prevent session fixation
        request()->session()->regenerate();

        return $user;
    }

    /**
     * Log out the current user.
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return User|null
     */
    public function getCurrentUser(): ?User
    {
        return Auth::user();
    }

    /**
     * Check if user is authenticated.
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return Auth::check();
    }
}
