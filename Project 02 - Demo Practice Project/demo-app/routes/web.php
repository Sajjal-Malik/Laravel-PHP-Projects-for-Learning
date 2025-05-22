<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SingleActionController;
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
    return view('welcome');
});

Route::get('/index', function(){
    return view('index');
});

Route::get('/register', function(){
    return view('customer');
});




// Route::get('/register', [RegistrationController::class, 'index']);

// Route::post('/register', [RegistrationController::class, 'register']);


Route::post('/customer', [CustomerController::class, 'store']);

// Route::get('/customer/create', [CustomerController::class, 'create']);

Route::get('/customer/view', [CustomerController::class, 'view']);

Route::get('/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');

Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');

Route::get('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');


// Route::get('/customers', function(){
//     $customers = Customer::all();
//     echo "<pre>";
//     print_r($customers->toArray());
// });


// Route::get('/', [DemoController::class, 'index']);

// Route::get('/about', [DemoController::class, 'about']);

// Route::get('/courses', SingleActionController::class);


// Route::resource('/photo', PhotoController::class);

// Route::get('/', function(){
//     return view('welcome');
// });

// Route::get('/about', function(){
//     return view('about');
// });

// Route::get('/courses', function(){
//     return view('courses');
// });


// Route::get('/', function ($name) {
//     return view('welcome');
// });


// Route::get('/{name?}', function ($name = null) {
//     $demo = '<h2>HTML Code Directly</h2>';
//     $data = compact('name', 'demo');
//     return view('home')->with($data);
// });


// Route::get('/demo/{name}/{id}', function ($name, $id=null) {
//     $data = compact('name', 'id');
//     return view('demo')->with($data);

// });

// Route::any('/test', function () {
//     echo "Using ANY METHOD but Hitting GET Request by Default";
// });

// Route::post('/test', function(){
//     echo "POST METHOD HIT";
// });

// Route::put('users/{id}', function(){});

// Route::patch('users/{id}', function(){});

// Route::patch('users/{id}', function(){});