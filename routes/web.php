<?php

use App\Http\Controllers\API\CustomerController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::resource('customers', CustomerController::class);
});
