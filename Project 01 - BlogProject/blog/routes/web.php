<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return view('hello');
});

Route::get('/greet', function () {
    $name = 'John'; // you can change this
    return view('greet', ['name' => $name]);
});
