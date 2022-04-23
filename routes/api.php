<?php

use App\Http\Controllers\Jwt\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([

        'middleware' => 'api',
        'prefix'     => 'v1',

], function ($router) {

    Route::group(['prefix' => 'user'], function () {

        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);

    });
    Route::post('register', [AuthController::class, 'register']);


});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
