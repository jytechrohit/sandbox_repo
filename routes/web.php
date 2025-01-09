<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Customer routes for web UI
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('customers.index');
    });
    Route::resource('customers', CustomerController::class);
});
