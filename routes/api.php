<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EncheresController;


use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::put('/edit', [AuthController::class, 'edit']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});




Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::resource('products', ProductController::class);  
    Route::get('/userProducts', [ProductController::class, 'userProducts']);
    Route::put('/winningBid/{product}', [ProductController::class, 'winningBid']);    
});

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::resource('encheres', EncheresController::class);
    Route::get('/productEnchere', [EncheresController::class, 'productEnchere']);    
    Route::get('/highestBid', [EncheresController::class, 'highestBid']);    

  
});

  




