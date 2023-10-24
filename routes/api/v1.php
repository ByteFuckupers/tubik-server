<?php


use Illuminate\Support\Facades\Route;


Route::middleware('api')->group(function () {
    Route::prefix('test')->group(function () {
        Route::get('/', [\App\Http\Controllers\V1\Test\TestController::class, 'get'])->name('test.test');
        Route::post('/', [\App\Http\Controllers\V1\Test\TestController::class, 'post'])->name('test.test');
    });


    Route::prefix('auth')->group(function () {
        Route::post('login', [\App\Http\Controllers\V1\Auth\AuthController::class, 'login'])->name('auth.login');
        Route::post('register', [\App\Http\Controllers\V1\Auth\AuthController::class, 'register'])->name('auth.register');
        Route::post('logout', [\App\Http\Controllers\V1\Auth\AuthController::class, 'logout'])->name('auth.logout');
        Route::post('refresh', [\App\Http\Controllers\V1\Auth\AuthController::class, 'refresh'])->name('auth.refresh');
        Route::get('me', [\App\Http\Controllers\V1\Auth\AuthController::class, 'me'])->name('auth.me');
    });

    Route::prefix('category')->group(function () {
        Route::get('', [\App\Http\Controllers\V1\Product\CategoryController::class, 'getCategories'])->name('category.getCategories');
        Route::get('{category}', [\App\Http\Controllers\V1\Product\CategoryController::class, 'categoryProduct'])->name('category.getCategories');
        Route::get('{category}/{subcategory}', [\App\Http\Controllers\V1\Product\CategoryController::class, 'subcategoryProduct'])->name('category.getCategories');

    });




    Route::prefix('product')->group(function () {
        Route::get('', [\App\Http\Controllers\V1\Product\ProductController::class, 'index'])->name('product.index');
        Route::get('{product}', [\App\Http\Controllers\V1\Product\ProductController::class, 'show'])->name('product.show');
    });
});



