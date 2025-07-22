<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/registerProduct', [ProductController::class, 'createProduct']);
Route::post('/registerCategory', [CategoryController::class, 'createCategory']);
Route::post('/registerColor',[ColorController::class,'createColor']);
Route::post('/registerSize',[SizeController::class,'createSize']);



Route::get('/products', [ProductController::class, 'fetchProduct']);
Route::get('/categories', [CategoryController::class, 'fetchCategory']);
Route::get('/colors', [ColorController::class, 'fetchColor']);
Route::get('/sizes', [SizeController::class, 'fetchSize']);
Route::get('/productFeatured', [ProductController::class, 'featuredProducts']);


