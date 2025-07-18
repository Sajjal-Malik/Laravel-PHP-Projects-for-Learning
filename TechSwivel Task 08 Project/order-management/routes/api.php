<?php

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\FirestoreController;
use App\Http\Controllers\API\FirestoreSyncController;
use App\Http\Controllers\API\OrderApiController;
use App\Http\Controllers\API\OrderSyncController;
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



Route::post('/signup', [AuthApiController::class, 'signup']);
Route::post('/signin', [AuthApiController::class, 'signin']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/updateProfile', [AuthApiController::class, 'updateProfile']);

    Route::prefix('order')->group(function () {

        Route::put('/updateOrder', [OrderApiController::class, 'updateOrder']);
        Route::get('/allUserOrder', [OrderApiController::class, 'getAllOrders']);

        Route::get('/{orderId}', [OrderApiController::class, 'getOrderDetail']);
        Route::put('/{orderId}/edit', [OrderApiController::class, 'editPendingOrder']);

        Route::post('/feedback', [OrderApiController::class, 'submitFeedback']);

        Route::post('/sync', [FirestoreController::class, 'write']);
        Route::get('/sync/{orderId}', [FirestoreController::class, 'read']);
    });

    Route::post('/firestore/order-sync', [OrderApiController::class, 'sync']);
});
