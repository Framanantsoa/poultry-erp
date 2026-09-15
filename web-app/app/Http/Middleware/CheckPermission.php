<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Ensure the authenticated user has at least one of the given permissions.
     *
     * Usage in routes:
     *   ->middleware('permission:breeds.view')
     *   ->middleware('permission:breeds.create,breeds.update')  // any of these
     *
     * @param  string  ...$permissions
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = $request->user();

        // Not authenticated? Shouldn't happen if 'auth' middleware runs first,
        // but be defensive.
        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        // No permissions specified — allow through
        if (empty($permissions)) {
            return $next($request);
        }

        // Read the user's permissions (cached — no DB hit)
        $userPermissions = $user->getAllPermissionsCached();

        // User needs at least ONE of the required permissions
        foreach ($permissions as $permission) {
            if (in_array($permission, $userPermissions, true)) {
                return $next($request);
            }
        }

        abort(403, 'You do not have permission to access this resource.');
    }
}
