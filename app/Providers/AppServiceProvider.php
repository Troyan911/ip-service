<?php

namespace App\Providers;

use App\Adapters\IpApiGeoProvider;
use App\Contracts\GeoProviderInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            GeoProviderInterface::class,
            IpApiGeoProvider::class
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
