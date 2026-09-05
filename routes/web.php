<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\OptionGroupController;
use App\Http\Controllers\SetupAdminController;
use Illuminate\Support\Facades\Route;

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
    });

require __DIR__.'/auth.php';
