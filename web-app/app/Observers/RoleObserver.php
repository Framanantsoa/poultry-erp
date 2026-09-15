<?php

namespace App\Observers;

use App\Models\Auth\Role;
use Illuminate\Support\Facades\Cache;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        $this->bust($role);
    }

    public function updated(Role $role): void
    {
        $this->bust($role);
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        $this->bust($role);
    }


    private function bust(Role $role): void {
        foreach ($role->users()->pluck('users.id') as $userId) {
            Cache::forget("user:{$userId}:permissions");
            Cache::forget("user:{$userId}:roles");
        }
    }
}
