<?php

use App\Http\Controllers\FormController;
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

Route::get('/firstForm', [FormController::class, 'getText']);

Route::post('/remove/spaces', [FormController::class, 'removeSpaces']);


Route::get('/secondForm', [FormController::class, 'getParagraph']);

Route::post('/words/counts', [FormController::class, 'countWords']);