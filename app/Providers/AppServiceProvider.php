<?php

namespace App\Providers;

use App\Repositories\CarsInterface;
use App\Repositories\StubApiServiceCarRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // TODO: Replace the "StubApiServiceCarRepository" with a real connector
        $this->app->singleton(CarsInterface::class, StubApiServiceCarRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
