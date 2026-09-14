<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 25);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Users
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->date('birthday')->nullable();
            $table->string('phone', 15)->unique();
            $table->string('email', 50)->nullable()->unique();
            $table->string('employee_id', 15)->unique();
            $table->string('password', 250);
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. Permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. User ↔ Role pivot
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
            $table->unique(['user_id', 'role_id'], 'uk_user_role');
        });

        // 5. Role ↔ Permission pivot
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id');
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
            $table->foreign('permission_id')->references('id')->on('permissions')->cascadeOnDelete();
            $table->unique(['role_id', 'permission_id'], 'uk_role_permission');
        });

        // 6. Logs
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action_name', 100);
            $table->string('table_name', 100)->nullable();
            $table->json('last_value')->nullable();
            $table->json('new_value')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });

        // 7. Sequences
        Schema::create('sequences', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sequence_key', 50);
            $table->unsignedBigInteger('current_value')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Reverse order — children first
        Schema::dropIfExists('sequences');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
