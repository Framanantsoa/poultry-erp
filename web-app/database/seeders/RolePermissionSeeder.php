<?php

namespace Database\Seeders;

use App\Models\Auth\Permission;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    // ─────────────────────────────────────────────
    // 1. Create all permissions (grouped by module)
    // ─────────────────────────────────────────────
        $permissions = [
            // Batches
            'batches.view', 'batches.create', 'batches.update',
            'breeds.view', 'breeds.create', 'breeds.update',

            // Production
            'production.view',
            'weights.view', 'weights.create', 'weights.update',
            'eggs.view', 'eggs.create', 'eggs.update',
            'feed.view', 'feed.create', 'feed.update',

            // Incubation
            'incubation.view', 'incubation.create', 'incubation.update',

            // Health & Mortality
            'mortality.view', 'mortality.create', 'mortality.update',

            // Sales
            'sales.view', 'sales.create', 'sales.update',

            // Analytics & Reports
            'reports.view', 'reports.financial', 'reports.export',

            // Predictions
            'predictions.view',

            // Security
            'security.view',
            'users.view', 'users.create', 'users.update', 'users.delete',
            'roles.view', 'roles.create', 'roles.update', 'roles.delete',
            'logs.view',

            // Settings
            'settings.view', 'settings.update',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(
                ['name' => $name],
                ['description' => $this->describe($name)]
            );
        }

    // ─────────────────────────────────────────────
    // 2. Create roles
    // ─────────────────────────────────────────────
        $admin = Role::firstOrCreate(
            ['name' => 'Admin'],
            ['description' => 'Full system access — manages users, roles, and settings']
        );

        $manager = Role::firstOrCreate(
            ['name' => 'Farm_manager'],
            ['description' => 'Manages daily farm operations and reports']
        );

        $worker = Role::firstOrCreate(
            ['name' => 'Worker'],
            ['description' => 'Records daily production, feed, and mortality data']
        );

    // ─────────────────────────────────────────────
    // 3. Assign permissions to roles
    // ─────────────────────────────────────────────
        $admin->permissions()->sync(Permission::pluck('id'));

        $manager->permissions()->sync(
            Permission::whereIn('name', [
                // Batches
                'batches.view', 'batches.create', 'batches.update',
                'breeds.view', 'breeds.create', 'breeds.update',

                // Production
                'production.view',
                'weights.view', 'weights.create', 'weights.update',
                'eggs.view', 'eggs.create', 'eggs.update',
                'feed.view', 'feed.create', 'feed.update',

                // Incubation
                'incubation.view', 'incubation.create', 'incubation.update',

                // Health & Mortality
                'mortality.view', 'mortality.create', 'mortality.update',

                // Sales
                'sales.view', 'sales.create', 'sales.update',

                // Analytics & Reports
                'reports.view', 'reports.financial', 'reports.export',

                // Predictions
                'predictions.view',
            ])->pluck('id')
        );

        $worker->permissions()->sync(
            Permission::whereIn('name', [
                // Read-only batches
                'batches.view', 'breeds.view',

                // Data entry
                'production.view',
                'weights.view', 'weights.create',
                'eggs.view', 'eggs.create',
                'feed.view', 'feed.create',
                'mortality.view', 'mortality.create',
                'sales.view', 'sales.create',
            ])->pluck('id')
        );

    // ─────────────────────────────────────────────
    // 4. Assign admin role to EMP0001
    // ─────────────────────────────────────────────
        $user = User::where('employee_id', 'EMP0001')->first();
        if ($user) {
            $user->roles()->syncWithoutDetaching([$admin->id]);
        }

        $this->command->info('Roles and permissions seeded.');
        $this->command->info('   Roles: admin, farm_manager, worker');
        $this->command->info('   Permissions: ' . Permission::count());
    }

    /**
     * Human-readable description for each permission.
     */
    private function describe(string $name): string
    {
        return match ($name) {
            'batches.view' => 'View all batches',
            'batches.create' => 'Create new batches',
            'batches.update' => 'Update existing batches',

            'breeds.view' => 'View breeds',
            'breeds.create' => 'Create breeds',
            'breeds.update' => 'Update breeds',

            'production.view' => 'View production overview',

            'weights.view' => 'View weekly weights',
            'weights.create' => 'Record weekly weights',
            'weights.update' => 'Update weekly weights',

            'eggs.view' => 'View egg production',
            'eggs.create' => 'Record egg production',
            'eggs.update' => 'Update egg production',

            'feed.view' => 'View feed consumption',
            'feed.create' => 'Record feed consumption',
            'feed.update' => 'Update feed consumption',

            'incubation.view' => 'View incubations',
            'incubation.create' => 'Create incubations',
            'incubation.update' => 'Update incubations',

            'mortality.view' => 'View mortality records',
            'mortality.create' => 'Record mortality',
            'mortality.update' => 'Update mortality records',

            'sales.view' => 'View sales',
            'sales.create' => 'Record sales',
            'sales.update' => 'Update sales',

            'reports.view' => 'View analytics and reports',
            'reports.financial' => 'View financial reports',
            'reports.export' => 'Export reports',

            'predictions.view' => 'View predictions',

            'security.view' => 'Access security section',
            'users.view' => 'View users',
            'users.create' => 'Create users',
            'users.update' => 'Update users',
            'users.delete' => 'Delete users',
            'roles.view' => 'View roles and permissions',
            'roles.create' => 'Create roles',
            'roles.update' => 'Update roles',
            'roles.delete' => 'Delete roles',
            'logs.view' => 'View audit logs',

            'settings.view' => 'View settings',
            'settings.update' => 'Update settings',

            default => $name,
        };
    }
}
