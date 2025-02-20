<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function (){
    Route::get('login', [LoginController::class, 'showLogin'])->name('show-login')->middleware('guest');
    Route::post('login', [LoginController::class, 'doLogin'])->name('do-login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['auth']], function (){
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::resource('customers', CustomerController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('employees', EmployeeController::class);
    });
});
