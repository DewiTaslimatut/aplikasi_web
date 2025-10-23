<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SalariesController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');

Route::resource('employees', EmployeeController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('salaries', SalariesController::class);
Route::resource('positions', PositionController::class);
Route::resource('attendances', AttendanceController::class);
Route::resource('reports', ReportController::class);
Route::post('/reports/generate', [ReportController::class, 'generateReport'])->name('reports.generate');

// Position Routes
Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');
Route::get('/positions/create', [PositionController::class, 'create'])->name('positions.create');
Route::post('/positions', [PositionController::class, 'store'])->name('positions.store');
Route::get('/positions/{id}', [PositionController::class, 'show'])->name('positions.show');
Route::get('/positions/{id}/edit', [PositionController::class, 'edit'])->name('positions.edit');
Route::put('/positions/{id}', [PositionController::class, 'update'])->name('positions.update');
Route::delete('/positions/{id}', [PositionController::class, 'destroy'])->name('positions.destroy');
Route::put('/positions/{id}/salary', [PositionController::class, 'updateSalary'])->name('positions.update.salary');