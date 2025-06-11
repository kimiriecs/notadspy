<?php

use App\Http\Controllers\WelcomeController;
use App\Modules\AdSpy\Http\Controller\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeController::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('subscriptions')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])
            ->name('subscriptions');
        Route::get('create', [SubscriptionController::class, 'create'])
            ->name('subscriptions.create');
        Route::post('store', [SubscriptionController::class, 'store'])
            ->name('subscriptions.store');
        Route::post('{id}/toggleStatus', [SubscriptionController::class, 'toggleStatus'])
            ->name('subscriptions.toggleStatus');
        Route::post('{id}/delete', [SubscriptionController::class, 'destroy'])
            ->name('subscriptions.delete');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
