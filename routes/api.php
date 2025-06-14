<?php

use App\Http\Controllers\Api\ProductsControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('loginapi', [ProductsControllerApi::class, 'loginapi']);

Route::get('products', [ProductsControllerApi::class, 'index'])->middleware('auth:sanctum'); 

Route::post('register', [ProductsControllerApi::class, 'createUserapi']);