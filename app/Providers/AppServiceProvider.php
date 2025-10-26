<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Partager les paramètres avec toutes les vues
        View::composer('*', function ($view) {
            // Récupérer les paramètres depuis le cache ou la base de données
            $settings = Cache::remember('app_settings', 3600, function () {
                return Setting::first() ?? new Setting();
            });
            
            $view->with('appSettings', $settings);
        });
    }
}