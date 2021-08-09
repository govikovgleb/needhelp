<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BasketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [ProductController::class, 'index'])->name('productList');

Route::post('add-to-basket', [BasketController::class, 'addToBasket'])->name('addToBasket');

Route::post('delete-from-basket', [BasketController::class, 'deleteFromBasket'])->name('deleteFromBasket');

Route::post('get-user-basket', [BasketController::class, 'getUserBasket'])->name('getUserBasket');


//Route::resource('products', 'ProductController');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/basket', [BasketController::class, 'basket'])->name('basket');
