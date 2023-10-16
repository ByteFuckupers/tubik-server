<?php


use Illuminate\Support\Facades\Route;


Route::middleware('api')->prefix('auth')->group(function (){
    Route::post('login', [\App\Http\Controllers\V1\Auth\AuthController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\V1\Auth\AuthController::class, 'register']);
    Route::post('logout', [\App\Http\Controllers\V1\Auth\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\V1\Auth\AuthController::class, 'refresh']);
    Route::post('me', [\App\Http\Controllers\V1\Auth\AuthController::class, 'me']);
});



