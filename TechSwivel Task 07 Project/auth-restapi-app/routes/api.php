<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;

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


Route::post('/signup', [AuthController::class, 'register']);
Route::post('/signin', [AuthController::class, 'login']);

Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
Route::post('/verify', [AuthController::class, 'verifyResetToken']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/profile', [AuthController::class, 'profile']);
});


Route::prefix('posts')->middleware('auth:sanctum')->group(function () {
    Route::post('/',       [PostController::class, 'store']);
    Route::get('/',        [PostController::class, 'index'])->withoutMiddleware('auth:sanctum');
    Route::get('{id}/edit',[PostController::class, 'edit']);
    Route::put('{id}',     [PostController::class, 'update']);
    Route::delete('{id}',  [PostController::class, 'destroy']);
});

Route::prefix('comments')->middleware('auth:sanctum')->group(function () {
    Route::post('/',        [CommentController::class, 'store']);
    Route::get('/',         [CommentController::class, 'index']);
    Route::get('{id}/edit', [CommentController::class, 'edit']);
    Route::put('{id}',      [CommentController::class, 'update']);
    Route::delete('{id}',   [CommentController::class, 'destroy']);
});