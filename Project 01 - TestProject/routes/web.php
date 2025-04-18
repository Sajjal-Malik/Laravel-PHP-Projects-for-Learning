<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about.index', ["name" => "Malik", "framework" => "PHP (Laravel)"]);
});

Route::get('/teas', function() {
    $teas = [
        ['name' => 'Masala Chai', 'price' => '$5', 'id' => 1],
        ['name' => 'Ginger Chai', 'price' => '$10', 'id' => 2],
        ['name' => 'Special Chai', 'price' => '$20', 'id' => 3]
    ];
    return view('/teas.index', ['teas' => $teas]);
});

Route::get('/teas/{id}', function($id) {
    $teas = [
        ['name' => 'Masala Chai', 'price' => '$5', 'id' => 1],
        ['name' => 'Ginger Chai', 'price' => '$10', 'id' => 2],
        ['name' => 'Special Chai', 'price' => '$20', 'id' => 3]
    ];
    return view('/teas.tedetail', ['tea' => $teas[$id - 1]]);
});