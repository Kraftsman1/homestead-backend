<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\API\PropertyTypeController;
use App\Http\Controllers\API\HostController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\AmenityController;

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
        Route::post('/', [PropertyController::class, 'store'])->middleware('auth:sanctum');
        Route::post('/{id}/favorite', [PropertyController::class, 'favorite'])->middleware('auth:sanctum');

        // Route::post('/', [DestinationController::class, 'store']);
        // Route::put('/{id}', [DestinationController::class, 'update']);
        // Route::delete('/{id}', [DestinationController::class, 'destroy']);
    });

    // Become a Host 
    Route::group([
        'prefix' => 'host',
        // middleware
        'middleware' => [JSONResponse::class]
    ], function () {
        Route::post('/become-a-host', [HostController::class, 'apply'])->middleware('auth:sanctum');
        // Route::post('/approve', [HostController::class, 'approve'])->middleware('auth:sanctum');
        // Route::post('/reject', [HostController::class, 'reject'])->middleware('auth:sanctum');
    });

    // // Admin Routes
    // Route::group([
    //     'middleware' => ['auth:sanctum', 'role:admin'],
    //     'prefix' => 'admin'
    // ], function() {
    //     // Add your admin routes here
    // });

    Route::group([
        'prefix' => 'property-types',
        // middleware
        'middleware' => [JSONResponse::class]
    ], function () {
        Route::get('/', [PropertyTypeController::class, 'index']);
        Route::get('/{id}', [PropertyTypeController::class, 'show']);
        Route::post('/', [PropertyTypeController::class, 'store']);
        Route::put('/{id}', [PropertyTypeController::class, 'update']);
    });

    // Amenities Routes
    Route::group([
        'prefix' => 'amenities',
        // middleware
        'middleware' => [JSONResponse::class]
    ], function () {
        Route::get('/', [AmenityController::class, 'index']);
        Route::get('/{id}', [AmenityController::class, 'show']);
        Route::post('/', [AmenityController::class, 'store']);
        Route::put('/{id}', [AmenityController::class, 'update']);
    });
    
    
    // User Routes
    Route::group([
        'middleware' => ['auth:sanctum'],
        'prefix' => 'user'
    ], function() {
        // Add user routes here
        Route::get('/', [UserController::class, 'index']);
        Route::put('/update-user', [UserController::class, 'update']);
        Route::post('/profile-picture', [UserController::class, 'update_profile_picture']);
        Route::post('/change-password', [UserController::class, 'change_password']);
        Route::get('/favorites', [UserController::class, 'favorites']);
    });

});