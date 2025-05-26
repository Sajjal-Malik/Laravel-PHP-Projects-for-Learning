<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RegistrationController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function(){
    return view('index');
});

Route::get('/register', [RegistrationController::class, 'index']);
Route::post('/register', [RegistrationController::class, 'register']);

Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::get('/customer', [CustomerController::class, 'view']);
Route::get('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
Route::post('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::post('/customer', [CustomerController::class, 'store']);
