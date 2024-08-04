<?php
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CategoryController;

   
Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
         
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('products', ProductController::class);
    // Route::post('categories', [CategoryController::class, 'store']);
    Route::resource('categories', CategoryController::class);
    // Route::post('products', [ProductController::class, 'store']);

    // Route::resource('products', ProductController::class)->only('store');
});