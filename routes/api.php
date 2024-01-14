<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DestinationController;
use App\Http\Middleware\JSONResponse;
// use App\Http\Controllers\API\UserController;



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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {

    // welcome route
    Route::get('/welcome', function () {
        return response()->json(['message' => 'Welcome to the API!']);
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

    // Destinations Routes
    Route::group([
        'prefix' => 'destinations',
        // middleware
        'middleware' => [JSONResponse::class]
    ], function () {
        Route::get('/', [DestinationController::class, 'index']);
        Route::get('/{id}', [DestinationController::class, 'show']);
        Route::post('/{id}/favorite', [DestinationController::class, 'favorite'])->middleware('auth:sanctum');


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
    
    // // Customer Routes
    // Route::group([
    //     'middleware' => ['auth:sanctum', 'role:customer'],
    //     'prefix' => 'customer'
    // ], function() {
    //     // Add your customer routes here
    // });

});