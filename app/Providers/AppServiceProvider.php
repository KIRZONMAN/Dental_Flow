<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\CitaServiceInterface;
use App\Services\CitaService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(
            CitaServiceInterface::class,
            CitaService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
