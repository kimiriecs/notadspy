<?php

namespace App\Providers;

use App\Bus\CommandBus\CommandBus;
use App\Bus\QueryBus\QueryBus;
use App\Interface\CommandBus\CommandBusInterface;
use App\Interface\QueryBus\QueryBusInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CommandBusInterface::class, CommandBus::class);
        $this->app->singleton(QueryBusInterface::class, QueryBus::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
