<?php

use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\API\ProfileApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('admin')->group(function () {
    Route::post('/signin', [AdminAuthController::class, 'signin'])->name('signin');

    Route::middleware(['auth:sanctum', 'role:1'])->group(function () {
        Route::post('/signout', [AdminAuthController::class, 'signout'])->name('signout');

        Route::prefix('profiles')->group(function () {
            Route::get('/', [ProfileApiController::class, 'getAllProfiles'])->name('profiles.all');
            Route::get('/{id}', [ProfileApiController::class, 'show'])->name('profiles.show');
            Route::post('/', [ProfileApiController::class, 'store'])->name('profiles.store');
            Route::put('/{id}', [ProfileApiController::class, 'update'])->name('profiles.update');
            Route::delete('/{id}', [ProfileApiController::class, 'destroy'])->name('profiles.destroy');
        });
    });
});
