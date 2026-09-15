<?php

namespace App\Models\Auth;

use App\Services\SequenceService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/** 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $birthday
 * @property string $phone
 * @property string|null $email
 * @property string $employee_id
 * @property string $password
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[Fillable(['first_name', 'last_name', 'birthday', 'phone',
 'email', 'employee_id', 'password'])]
#[Hidden(['password'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'birthday' => 'date',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * The attributes that should be guarded.
     *
     * @var list<string>
     */
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function roles(): BelongsToMany {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withTimestamps();
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string {
        return $this->first_name . ' ' .$this->last_name;
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(string ...$roles): bool {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Check if user has a specific permission (via any of their roles).
     */
    public function hasPermission(string $permission): bool {
        return $this->permissions()->where('name', $permission)->exists();
    }

    /**
     * Get all permissions via the user's roles.
     */
    public function permissions() {
        return Permission::query()
            ->whereHas('roles', function ($q) {
                $q->whereIn('roles.id', $this->roles()->pluck('roles.id'));
            });
    }


    /**
     * Point Laravel to the correct factory location.
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new()
            ->withSequenceService(app(SequenceService::class));
    }


    /**
     * Get all permissions for the user, via their roles.
    */
    public function getAllPermissions() {
        return Permission::whereHas('roles', function ($q) {
            $q->whereIn('roles.id', $this->roles->pluck('id'));
        })->get();
    }

    /**
     * Get all role names as a flat array.
    */
    public function getAllRoleNames(): array {
        return $this->roles
            ->pluck('name')->unique()->values()
            ->toArray();
    }

    /**
     * Get all permission names as a flat array.
    */
    public function getAllPermissionNames(): array {
        return $this->roles
            ->flatMap(fn ($role) => $role->permissions)
            ->pluck('name')->unique()->values()
            ->toArray();
    }


// ------------------------
// CACHE
// ------------------------
/**
 * Get all permissions for the user, cached for 1 hour.
 */
    public function getAllPermissionsCached(): array {
        return Cache::remember(
            "user:{$this->id}:permissions",
            now()->addHour(),
            fn () => $this->roles
                ->flatMap(fn ($role) => $role->permissions)
                ->pluck('name')
                ->unique()->values()->all()
        );
    }

/**
 * Get all role names for the user, cached for 1 hour.
 */
    public function getAllRolesCached(): array {
        return Cache::remember(
            "user:{$this->id}:roles",
            now()->addHour(),
            fn () => $this->roles->pluck('name')->all()
        );
    }

/**
 * Clear this user's cached roles + permissions.
 */
    public function forgetAuthorizationCache(): void {
        Cache::forget("user:{$this->id}:permissions");
        Cache::forget("user:{$this->id}:roles");
    }
}
