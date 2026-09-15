<?php

namespace App\Observers;

use App\Models\Auth\Permission;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PermissionObserver
{
    public function created(Permission $permission): void
    {
        $this->bust($permission);
    }

    public function deleted(Permission $permission): void
    {
        $this->bust($permission);
    }

    /**
     * Bust cache for every user who has a role holding this permission.
     */
    private function bust(Permission $permission): void
    {
        $userIds = DB::table('user_roles')
            ->join('role_permissions', 'user_roles.role_id', '=', 'role_permissions.role_id')
            ->where('role_permissions.permission_id', $permission->id)
            ->pluck('user_roles.user_id')
            ->unique();

        foreach ($userIds as $userId) {
            Cache::forget("user:{$userId}:permissions");
            Cache::forget("user:{$userId}:roles");
        }
    }
}
