<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Auto-set APP_URL mengikuti IP/host dari request yang masuk
        // Berguna saat server pindah device atau IP berubah
        if ($this->app->runningInConsole() === false) {
            $request = $this->app['request'];
            $url = $request->getScheme() . '://' . $request->getHttpHost();
            config(['app.url' => $url]);
            \Illuminate\Support\Facades\URL::forceRootUrl($url);
        }
    }
}
