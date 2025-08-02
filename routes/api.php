<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/registerCategory', [CategoryController::class, 'createCategory']);
Route::post('/registerColor', [ColorController::class, 'createColor']);
Route::post('/registerSize', [SizeController::class, 'createSize']);



Route::get('/products', [ProductController::class, 'fetchProduct']);
Route::get('/categories', [CategoryController::class, 'fetchCategory']);
Route::get('/colors', [ColorController::class, 'fetchColor']);
Route::get('/sizes', [SizeController::class, 'fetchSize']);
Route::get('/productFeatured', [ProductController::class, 'featuredProducts']);
Route::get('/product/{id}', [ProductController::class, 'fetchProductId']);
Route::get('/recomendatation/{id}', [ProductController::class, 'recomendation']);


Route::prefix('adm')->middleware('auth:sanctum')->group(function () {
    Route::post('/registerProduct', [ProductController::class, 'createProduct'])->middleware('auth:sanctum');
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [UserController::class, 'createUser']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/loginGoogle',[UserController::class,'LoginGoogle']);
});
