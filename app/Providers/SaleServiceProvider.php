<?php

namespace App\Providers;

use App\Services\SaleService;
use Illuminate\Support\ServiceProvider;

class SaleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SaleService::class, function(){
            return new SaleService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
