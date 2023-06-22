<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Public
Route::prefix('auth')->group(function() {
    Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\API\AuthController::class, 'register']);
    Route::post('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout'])->middleware('auth:api');
});

Route::group([
    'middleware' => 'auth:api,throttle:api',
], function() {
    Route::prefix('user')->group(function() {
        // Profile
        Route::get('/profile', [\App\Http\Controllers\API\AuthController::class, 'profile']);
    });

    // Brand
    Route::resource('brand', \App\Http\Controllers\API\BrandController::class);
    
    // Car
    Route::post('car/{car}', [\App\Http\Controllers\API\CarsController::class, 'update']);
    Route::resource('car', \App\Http\Controllers\API\CarsController::class)->except([
        'update'
    ]);
});