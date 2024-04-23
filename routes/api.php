<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\HomeController;

use App\Http\Middleware\JSONResponse;



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

Route::prefix('v1')->group(function () {
    // welcome route
    Route::get('/welcome', function () {
        return response()->json(['message' => 'Welcome to the DC Engine API!']);
    });

    // Authentication Routes
    Route::group([
        'prefix' => 'auth',
        // middleware
        'middleware' => [JSONResponse::class]
    ], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('signup', [AuthController::class, 'signup']);
    
        Route::group([
            'middleware' => 'auth:sanctum'
        ], function() {
            Route::get('logout', [AuthController::class, 'logout']);
            Route::get('user', [AuthController::class, 'user']);
        });
    });

    // Search Route Group
    Route::group([
        'prefix' => 'search',
        // middleware
        'middleware' => [JSONResponse::class]
    
    ],function () {
        Route::get('/', [HomeController::class, 'search']);
        Route::get('/suggestions', [HomeController::class, 'search_suggestions']);
    });

    // Destinations Routes
    // Route::group([
    //     'prefix' => 'destinations',
    //     // middleware
    //     'middleware' => [JSONResponse::class]
    // ], function () {
    //     Route::get('/', [DestinationController::class, 'index']);
    //     Route::get('/{id}', [DestinationController::class, 'show']);
    //     Route::post('/{id}/favorite', [DestinationController::class, 'favorite'])->middleware('auth:sanctum');

    //     // Route::post('/', [DestinationController::class, 'store']);
    //     // Route::put('/{id}', [DestinationController::class, 'update']);
    //     // Route::delete('/{id}', [DestinationController::class, 'destroy']);
    // });

    Route::group([
        'prefix' => 'properties',
        // middleware
        'middleware' => [JSONResponse::class]
    ], function () {
        Route::get('/', [PropertyController::class, 'index']);
        Route::get('/{id}', [PropertyController::class, 'show']);
        Route::post('/{id}/favorite', [PropertyController::class, 'favorite'])->middleware('auth:sanctum');

        // Route::post('/', [DestinationController::class, 'store']);
        // Route::put('/{id}', [DestinationController::class, 'update']);
        // Route::delete('/{id}', [DestinationController::class, 'destroy']);
    });

    // // Admin Routes
    // Route::group([
    //     'middleware' => ['auth:sanctum', 'role:admin'],
    //     'prefix' => 'admin'
    // ], function() {
    //     // Add your admin routes here
    // });
    
    // User Routes
    Route::group([
        'middleware' => ['auth:sanctum'],
        'prefix' => 'user'
    ], function() {
        // Add user routes here
        Route::get('/', [UserController::class, 'index']);
        Route::put('/profile', [UserController::class, 'update']);
        Route::post('/profile-picture', [UserController::class, 'update_profile_picture']);
        Route::post('/change-password', [UserController::class, 'change_password']);
        Route::get('/favorites', [UserController::class, 'favorites']);
    });

});