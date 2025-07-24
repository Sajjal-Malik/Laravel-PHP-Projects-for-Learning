<?php

use App\Http\Controllers\Admin\ProfileAjaxController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->middleware(['auth', 'role:1'])->group(function () {

    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');

    Route::get('/profiles', [ProfileAjaxController::class, 'index'])->name('profiles.index');
    Route::get('/profiles/{id}', [ProfileAjaxController::class, 'show'])->name('profiles.show');
    Route::post('/profiles', [ProfileAjaxController::class, 'store'])->name('profiles.store');
    Route::get('/profiles/{id}/edit', [ProfileAjaxController::class, 'edit'])->name('profiles.edit');
    Route::put('/profiles/{id}', [ProfileAjaxController::class, 'update'])->name('profiles.update');
    Route::delete('/profiles/{id}', [ProfileAjaxController::class, 'destroy'])->name('profiles.destroy');


    Route::get('/dashboard', [ProfileAjaxController::class, 'count'])->name('admin.dashboard');
});
