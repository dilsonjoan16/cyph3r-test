<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShoppingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/show/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/buy/{product}', [ProductController::class, 'buy'])->name('products.buy');
        Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/update', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/delete', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    Route::group(['prefix' => 'shopping'], function () {
        Route::get('/delete-product/{shopping}/{product}', [ShoppingController::class, 'deleteProduct'])->name('shopping.delete-product');
        Route::get('/complete/{shopping}', [ShoppingController::class, 'complete'])->name('shopping.complete');
    });

    Route::group(['prefix' => 'reports'], function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('/store', [ReportController::class, 'store'])->name('reports.store');
        Route::get('/show/{report}', [ReportController::class, 'show'])->name('reports.show');
    });

    Route::get('/currency/{currency}', [CurrencyController::class, 'updateCurrentCurrency'])->name('currency.update-current-currency');
});

require __DIR__.'/auth.php';
