<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TypesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas para Products
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/new', [ProductsController::class, 'create'])->name('products.create');
Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
Route::get('/products/edit/{id}', [ProductsController::class, 'edit'])->name('products.edit');
Route::post('/products/update', [ProductsController::class, 'update'])->name('products.update');
Route::post('/products/delete/{id}', [ProductsController::class, 'destroy'])->name('products.delete');

// Rotas para Types
Route::get('/types', [TypesController::class, 'index'])->name('types.index');
Route::get('/types/new', [TypesController::class, 'create'])->name('types.create');
Route::post('/types', [TypesController::class, 'store'])->name('types.store');
Route::get('/types/edit/{id}', [TypesController::class, 'edit'])->name('types.edit');
Route::post('/types/update', [TypesController::class, 'update'])->name('types.update');
Route::post('/types/delete/{id}', [TypesController::class, 'destroy'])->name('types.delete');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';