<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
        // Force base URL only when APP_URL is set
        $appUrl = config('app.url');
        if (!empty($appUrl)) {
            URL::forceRootUrl($appUrl);
        }
    }
}
