<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function (){
    Route::get('login', [LoginController::class, 'showLogin'])->name('show-login')->middleware('guest');
    Route::post('login', [LoginController::class, 'doLogin'])->name('do-login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['auth']], function (){
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::resource('customers', CustomerController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('employees', EmployeeController::class);
        Route::get('employees-by-service/{service}', [EmployeeController::class, 'getAvailableEmployees'])
            ->name('employees.by.service');
        Route::get('reservation-employee/{reservationId}/{serviceId}', [ReservationController::class, 'getEmployeeForService']);
        Route::post('reservations/update-status', [ReservationController::class, 'updateStatus'])
            ->name('reservations.updateStatus');
        Route::resource('reservations', ReservationController::class);
        Route::resource('transactions', TransactionController::class);
        Route::resource('categories', CategoryController::class);
        Route::delete('products/images/{id}/delete', [ProductController::class, 'removeImage']);
        Route::resource('products', ProductController::class);
        Route::resource('orders', OrderController::class);
    });
});
