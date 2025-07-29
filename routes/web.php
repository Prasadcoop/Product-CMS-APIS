<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\Admin\AuthController;
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


Route::get('/', [AuthController::class, 'showLoginForm'])->name('admin.auth.index');
Route::post('/', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::prefix('admin')->middleware('auth')->group(function () {
   
    Route::resource('products', ProductController::class, ['as' => 'admin']);
    Route::get('cart', [CartController::class, 'index'])->name('admin.cart.index');
    Route::resource('orders', OrderController::class, ['as' => 'admin'])->only(['index', 'show']);
   
});



