<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    /**
     * Show the login page.
     *
     * @return Response|RedirectResponse
     */
    public function create(): Response|RedirectResponse
    {
        // If user is already authenticated, redirect to dashboard
        if ($this->authService->isAuthenticated()) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('Auth/Login', [
            'status' => session('status'),
            'canResetPassword' => false,
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();

            // Attempt login
            $user = $this->authService->login(
                $validated['employee_id'],
                $validated['password']
            );

            // Log successful login
            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'employee_id' => $user->employee_id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Redirect to intended page or dashboard
            return redirect()->intended(route('dashboard'));

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw validation exceptions to be handled by Inertia
            throw $e;
        } catch (\Exception $e) {
            Log::error('Login attempt failed', [
                'employee_id' => $request->employee_id,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'employee_id' => 'An error occurred during login. Please try again.',
            ])->onlyInput('employee_id');
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            $user = $this->authService->getCurrentUser();
            
            $this->authService->logout();

            // Invalidate the session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Log::info('User logged out', [
                'user_id' => $user?->id,
                'employee_id' => $user?->employee_id,
            ]);

            return redirect()->route('login')->with([
                'status' => 'You have been logged out successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Logout failed', [
                'error' => $e->getMessage()
            ]);

            return redirect()->route('login')->with([
                'error' => 'An error occurred during logout.'
            ]);
        }
    }
}