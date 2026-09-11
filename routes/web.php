<?php

use App\Http\Controllers\Dashboard\AdminOrderController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CustomerMenuController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OptionController;
use App\Http\Controllers\Dashboard\OptionGroupController;
use App\Http\Controllers\Frontend\PaymentCallbackController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Api\MidtransWebhookController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\SetupAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CustomerMenuController::class, 'index'])->name('home');
Route::get('/menu', [CustomerMenuController::class, 'index'])->name('customer.menu');
Route::get('/menu/{product:slug}', [CustomerMenuController::class, 'show'])->name('customer.menu.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{cartItemKey}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cartItemKey}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

Route::post('/webhooks/midtrans', [MidtransWebhookController::class, 'handle'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class]);

Route::post('/payment/midtrans/callback', [PaymentCallbackController::class, 'handle'])
    ->name('payment.midtrans.callback')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class]);

Route::get('/setup-admin', [SetupAdminController::class, 'create'])->name('setup-admin.create');
Route::post('/setup-admin', [SetupAdminController::class, 'store'])->name('setup-admin.store');

Route::middleware('auth')
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])
            ->name('index');
        Route::get('/chart-data', [DashboardController::class, 'chartData'])
            ->name('chart-data');

        Route::resource('categories', CategoryController::class)
            ->except(['show']);
        Route::patch('categories/{category}/toggle', [CategoryController::class, 'toggle'])
            ->name('categories.toggle');

        Route::resource('option-groups', OptionGroupController::class)
            ->except(['show']);
        Route::patch('option-groups/{optionGroup}/toggle-active', [OptionGroupController::class, 'toggleActive'])
            ->name('option-groups.toggle-active');
        Route::patch('option-groups/{optionGroup}/toggle-required', [OptionGroupController::class, 'toggleRequired'])
            ->name('option-groups.toggle-required');
        Route::get('option-groups/{optionGroup}/manage', [OptionGroupController::class, 'manage'])
            ->name('option-groups.manage');

        Route::post('options', [OptionController::class, 'store'])->name('options.store');
        Route::put('options/{option}', [OptionController::class, 'update'])->name('options.update');
        Route::delete('options/{option}', [OptionController::class, 'destroy'])->name('options.destroy');
        Route::patch('options/{option}/toggle-available', [OptionController::class, 'toggleAvailable'])
            ->name('options.toggle-available');

        Route::resource('products', ProductController::class)
            ->except(['show']);
        Route::patch('products/{product}/toggle-availability', [ProductController::class, 'toggleAvailability'])
            ->name('products.toggle-availability');

        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('offline-orders', [\App\Http\Controllers\Dashboard\OfflineOrderController::class, 'index'])->name('offline-orders.index');
        Route::get('offline-orders/create', [\App\Http\Controllers\Dashboard\OfflineOrderController::class, 'create'])->name('offline-orders.create');
        Route::post('offline-orders', [\App\Http\Controllers\Dashboard\OfflineOrderController::class, 'store'])->name('offline-orders.store');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');

        Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('reports/products', [ReportController::class, 'products'])->name('reports.products');
        Route::get('reports/payments', [ReportController::class, 'payments'])->name('reports.payments');
        Route::get('reports/order-types', [ReportController::class, 'orderTypes'])->name('reports.order-types');

        Route::get('reports/sales/export/excel', [ReportController::class, 'salesExportExcel'])->name('reports.sales.export.excel');
        Route::get('reports/sales/export/pdf', [ReportController::class, 'salesExportPdf'])->name('reports.sales.export.pdf');

        Route::get('reports/products/export/excel', [ReportController::class, 'productsExportExcel'])->name('reports.products.export.excel');
        Route::get('reports/products/export/pdf', [ReportController::class, 'productsExportPdf'])->name('reports.products.export.pdf');

        Route::get('reports/payments/export/excel', [ReportController::class, 'paymentsExportExcel'])->name('reports.payments.export.excel');
        Route::get('reports/payments/export/pdf', [ReportController::class, 'paymentsExportPdf'])->name('reports.payments.export.pdf');

        Route::get('reports/order-types/export/excel', [ReportController::class, 'orderTypesExportExcel'])->name('reports.order-types.export.excel');
        Route::get('reports/order-types/export/pdf', [ReportController::class, 'orderTypesExportPdf'])->name('reports.order-types.export.pdf');

        Route::get('activity-log', [\App\Http\Controllers\Dashboard\ActivityLogController::class, 'index'])->name('activity-log.index');
    });

require __DIR__.'/auth.php';

