<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;


use App\Http\Middleware\IsAdmin;

use Illuminate\Support\Facades\Http;

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
    $products = Http::get('http://localhost:8001/getItens');
    
    return view('products',["products" => json_decode($products)]);
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    
    Route::get('/signup', [SignUpController::class, 'create'])->name('signup');
    Route::post('/signup', [SignUpController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy']);
    
    Route::get('/user-update', [UserController::class, 'create']);
    Route::post('/user-update', [UserController::class, 'update']);
    Route::post('/user-delete', [UserController::class, 'delete']);
    
    Route::get('/cart', [CartController::class, 'view']);
    Route::post('/cart/delete', [CartController::class, 'delete']);    
    Route::post('/cart/update', [CartController::class, 'update']);    
    Route::post('/addToCart', [CartController::class, 'addToCart']);

    Route::get('/orders', [OrderController::class, 'view']);
    Route::get('/orders/filter', [OrderController::class, 'view']);
    Route::post('/order/create', [OrderController::class, 'create']);
    Route::post('/order/update', [OrderController::class, 'update']);

    Route::get('/orders/all', [OrderController::class, 'adminView'])->middleware([IsAdmin::class]);   
    Route::get('/orders/filter/all', [OrderController::class, 'adminView'])->middleware([IsAdmin::class]);   
    //Route::get('/orders/update/all', [OrderController::class, 'adminView'])->middleware([IsAdmin::class]);   
    if(Auth::user() && Auth::user()->admin == true) {
    } else {
        return redirect('/');
    }
});

Route::get('/products', function() {
    $products = Http::get('http://localhost:8001/getItens');

    return view('products',["products" => json_decode($products)]);
});


