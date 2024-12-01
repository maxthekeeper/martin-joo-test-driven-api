<?php

use App\Http\Controllers\Api\v1\DepartmentController;
use App\Http\Controllers\Api\v1\DepartmentEmployeeController;
use App\Http\Controllers\Api\v1\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');
Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');

Route::get('/departments/{department}/employees', [DepartmentEmployeeController::class, 'index'])->name('department-employees.index');

Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
