<?php

use App\Http\Controllers\WelcomeController;
use App\Modules\AdSpy\Http\Controller\SubscriptionController;
use App\Modules\User\Http\Controller\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', WelcomeController::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('subscriptions')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])
            ->name('subscriptions');
        Route::get('create', [SubscriptionController::class, 'create'])
            ->name('subscriptions.create');
    });

    Route::get('notification-channels', function () {
        return Inertia::render('NotificationChannels');
    })->name('notification-channels');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
