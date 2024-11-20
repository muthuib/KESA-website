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
Route::get('/resources', [ResourceController::class, 'index'])->name('index');  // To list all resources
Route::post('/resource/store', [ResourceController::class, 'store'])->name('resource.store'); // To create a new resource
Route::get('/resources/{id}', [ResourceController::class, 'show']); // To show a single resource
Route::put('/resources/{id}', [ResourceController::class, 'update']); // To update a resource
Route::delete('/resources/{id}', [ResourceController::class, 'destroy']); // To delete a resource
Route::get('/resource/create', [ResourceController::class, 'create'])->name('create');// To show the form for creating a resource
});