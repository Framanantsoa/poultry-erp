<?php

namespace App\Http\Controllers;

use App\Models\Auth\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        return Inertia::render('Dashboard', [
            'user' => [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'last_name' => strtoupper($user->last_name),
                'employee_id' => $user->employee_id,
                'roles' => $user->getAllRoleNames(),
                'permissions' => $user->getAllPermissionNames()
            ]
        ]);
    }
}
