<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::resource('customer', CustomerController::class)
    ->middleware('auth')
    ->only('index', 'store', 'update', 'create', 'show');

Route::resource('work', WorkController::class)
    ->middleware('auth')
    ->only('index', 'show', 'store');

Route::get('/work/create/{customerId}', [WorkController::class, 'create'])
    ->middleware('auth')
    ->name('work.create');

Route::resource('product', ProductController::class)
    ->middleware('auth')
    ->only('destroy', 'store', 'update', 'index');

require __DIR__.'/auth.php';
