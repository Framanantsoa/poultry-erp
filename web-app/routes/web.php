<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Batches\BreedController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'getProfile'])->name('profile');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

// BREEDS
    Route::middleware('permission:breeds.view')->group(function () {
        Route::get('/breeds', [BreedController::class, 'index'])->name('breeds.index');
    });    
    
    Route::middleware('permission:breeds.create')->group(function () {
        Route::get('/breeds/create', [BreedController::class, 'create'])->name('breeds.create');
        Route::post('/breeds', [BreedController::class, 'store'])->name('breeds.store');
    });
    // Route::get('/breeds/{breed}/edit', [BreedController::class, 'edit'])->name('breeds.edit');
    // Route::put('/breeds/{breed}', [BreedController::class, 'update'])->name('breeds.update');
});
