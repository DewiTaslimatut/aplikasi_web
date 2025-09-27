<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/employees', [EmployeeController::class, 'index']);
Route::resource('employees', EmployeeController::class);