<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'isActive'])->group(function () {

    Route::middleware(['role:1'])->group(function () {

        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/status/{id}', [UserController::class, 'toggleBlock'])->name('users.toggleBlock');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');

        
        Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
        Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
        Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
        Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('companies.show');
        Route::get('/companies/{id}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
        Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('companies.update');
        Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');

        
        Route::get('/employees', [UserController::class, 'employeeIndex'])->name('employees.index');
        Route::get('/employees/create', [UserController::class, 'employeeCreate'])->name('employees.create');
        Route::post('/employees', [UserController::class, 'employeeStore'])->name('employees.store');
        Route::get('/employees/{id}', [UserController::class, 'employeeShow'])->name('employees.show');
        Route::get('/employees/{id}/edit', [UserController::class, 'employeeEdit'])->name('employees.edit');
        Route::put('/employees/{id}', [UserController::class, 'employeeUpdate'])->name('employees.update');
        Route::delete('/employees/{id}', [UserController::class, 'employeeDestroy'])->name('employees.destroy');
    });
});


