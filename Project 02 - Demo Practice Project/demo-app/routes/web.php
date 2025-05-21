<?php

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

Route::get('/demo/{name}/{id}', function ($name, $id=null) {
    $data = compact('name', 'id');
    return view('demo')->with($data);

});

Route::any('/test', function () {
    echo "Using ANY METHOD but Hitting GET Request by Default";
});

// Route::post('/test', function(){
//     echo "POST METHOD HIT";
// });

// Route::put('users/{id}', function(){});

// Route::patch('users/{id}', function(){});

// Route::patch('users/{id}', function(){});