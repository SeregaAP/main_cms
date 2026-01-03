<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DocumentContentRenderer;
use App\Services\TvService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DocumentContentRenderer::class, function ($app) {
        return new DocumentContentRenderer($app->make(TvService::class));
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
