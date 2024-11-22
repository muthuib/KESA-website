<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ResourceController;



Route::get('/', [HomeController::class, 'index'])->name('home');

// Registration routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/app', function () {
        return view('layouts.app');
    })->name('app');
});

// routes for resources
Route::middleware('auth')->group(function () {
    // Only accessible to authenticated users/  logged in users
    Route::get('resources', [ResourceController::class, 'index'])->name('resources.index'); // Show all resources
    Route::get('resources/create', [ResourceController::class, 'create'])->name('resources.create'); // Show create form
    Route::post('resources', [ResourceController::class, 'store'])->name('resources.store'); // Store new resource
    Route::get('resources/{resource}/edit', [ResourceController::class, 'edit'])->name('resources.edit'); //show edit form
    Route::put('resources/{resource}', [ResourceController::class, 'update'])->name('resources.update'); //update edited resource
    Route::delete('resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy'); //deletes resource
    // Add any other routes that should be protected by authentication here
});
Route::get('resources/{resource}', [ResourceController::class, 'view'])->name('resources.view'); //views resource
Route::get('/show', [ResourceController::class, 'showResources'])->name('resources.show');//display resources to end user