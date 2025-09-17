<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/product', [HomeController::class, 'products'])->name('product');
Route::get('/product/single', [HomeController::class, 'productSingle'])->name('product.single');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::match(['get', 'post'], '/settings', [AdminController::class, 'settings'])->name('settings');
    Route::match(['put', 'post'], '/settings/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');
    
    // Jumbotron routes
    Route::get('/jumbotron', [AdminController::class, 'jumbotron'])->name('jumbotron');
    Route::post('/jumbotron', [AdminController::class, 'jumbotronStore'])->name('jumbotron.store');
    Route::put('/jumbotron/{id}', [AdminController::class, 'jumbotronUpdate'])->name('jumbotron.update');
    Route::delete('/jumbotron/{id}', [AdminController::class, 'jumbotronDestroy'])->name('jumbotron.destroy');

    Route::get('/about', [AdminController::class, 'about'])->name('about');
    Route::put('/about/update', [AdminController::class, 'aboutUpdate'])->name('about.update');
    
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    Route::patch('/products/{product}/toggle-status', [AdminController::class, 'toggleStatus'])->name('products.toggle-status');
});

// API routes for products
Route::prefix('api')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});

