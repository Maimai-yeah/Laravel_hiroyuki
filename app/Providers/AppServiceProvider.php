<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bootstrap 5 のページネーション
        Paginator::useBootstrapFive();

        // 本番環境で HTTPS を強制
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
