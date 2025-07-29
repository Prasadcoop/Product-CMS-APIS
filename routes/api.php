<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\UserControllerr;
use App\Http\Controllers\CartApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/register', [UserControllerr::class, 'register']);
Route::post('/login', [UserControllerr::class, 'login']);

Route::middleware(['auth:api', 'check.token'])->group(function () {
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::post('/products', [ProductApiController::class, 'store']);
    Route::get('/products/{id}', [ProductApiController::class, 'show']);
    Route::put('/products/{id}', [ProductApiController::class, 'update']);
    Route::delete('/products/{id}', [ProductApiController::class, 'destroy']);
    Route::delete('/productimg/{id}', [ProductApiController::class, 'destroyimg']);
});

Route::middleware('auth:api')->prefix('cart')->group(function () {
    Route::post('/add', [CartApiController::class, 'store']);
    Route::put('/update/{id}', [CartApiController::class, 'update']);
    Route::delete('/delete/{id}', [CartApiController::class, 'destroy']);
    Route::get('/list', [CartApiController::class, 'index']);
    Route::post('/checkout', [CartApiController::class, 'checkout']);
});