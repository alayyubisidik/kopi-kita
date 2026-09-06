<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerMenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\OptionGroupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SetupAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CustomerMenuController::class, 'index'])->name('customer.menu');
Route::get('/menu/{product:slug}', [CustomerMenuController::class, 'show'])->name('customer.menu.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{cartItemKey}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cartItemKey}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/setup-admin', [SetupAdminController::class, 'create'])->name('setup-admin.create');
Route::post('/setup-admin', [SetupAdminController::class, 'store'])->name('setup-admin.store');

Route::middleware('auth')
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('index');

        Route::resource('categories', CategoryController::class)
            ->except(['show']);

        Route::resource('option-groups', OptionGroupController::class)
            ->except(['show']);

        Route::resource('options', OptionController::class)
            ->except(['show']);

        Route::resource('products', ProductController::class)
            ->except(['show']);
    });

require __DIR__.'/auth.php';
