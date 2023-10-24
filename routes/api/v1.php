<?php


use Illuminate\Support\Facades\Route;



Route::prefix('test')->group(function (){
    Route::get('/', [\App\Http\Controllers\V1\Test\TestController::class, 'get'])->name('test.test');
    Route::post('/', [\App\Http\Controllers\V1\Test\TestController::class, 'post'])->name('test.test');
});


Route::middleware('api')->prefix('auth')->group(function (){
    Route::post('login', [\App\Http\Controllers\V1\Auth\AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [\App\Http\Controllers\V1\Auth\AuthController::class, 'register'])->name('auth.register');
    Route::post('logout', [\App\Http\Controllers\V1\Auth\AuthController::class, 'logout'])->name('auth.logout');
    Route::post('refresh', [\App\Http\Controllers\V1\Auth\AuthController::class, 'refresh'])->name('auth.refresh');
    Route::get('me', [\App\Http\Controllers\V1\Auth\AuthController::class, 'me'])->name('auth.me');
});




Route::middleware('api')->group(function (){
    Route::get('category', [\App\Http\Controllers\V1\Product\CategoryController::class, 'index'])->name('product.category');
});



