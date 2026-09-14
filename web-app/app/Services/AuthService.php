<?php

namespace App\Services;

use App\Models\Auth\User;
use Exception;
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
    public function login(string $employeeId, string $password): User {
    // Find user by employee_id
        $user = User::with('roles.permissions')
            ->where('employee_id', $employeeId)->first();

    // Check if user exists and password matches
        if (!$user || !Hash::check($password, $user->password)) {
            throw new Exception("The provided credentials are incorrect.");
        }

    // Attempt to log in (this will set the session)
        if (!Auth::attempt(['employee_id' => $employeeId,
         'password' => $password])) {
            throw ValidationException::withMessages([
                'employee_id' => ['Authentication failed.'],
            ]);
        }

    // Regenerate session to prevent session fixation
        request()->session()->regenerate();

    // Refresh user with roles + permissions for the current session
        $user->load('roles.permissions');

    // Log the login action
        LogService::addAction(
            actionName: 'LOGIN',
            userId: $user->id,
            lastValue: null,
            newValue: null
        );

        return $user;
    }

    /**
     * Log out the current user.
     *
     * @return void
     */
    public function logout(): void {
        $user = $this->getCurrentUser();

    // Log the logout action
        if ($user) {
            LogService::addAction(
                actionName: 'LOGOUT',
                userId: $user->id,
                lastValue: null,
                newValue: null
            );
        }

        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return User|null
     */
    public function getCurrentUser(): ?User {
        return Auth::user();
    }

    /**
     * Check if user is authenticated.
     *
     * @return bool
     */
    public function isAuthenticated(): bool {
        return Auth::check();
    }
}
