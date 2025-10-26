<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     * Ceci sera remplacé par la logique dynamique ci-dessous
     *
     * @var string
     */
     public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Redirection dynamique selon le rôle de l'utilisateur après authentification
     */
    public static function redirectTo()
    {
        // Obtenir l'utilisateur actuellement authentifié
        $user = auth()->user();

        // Rediriger selon le rôle
        if ($user && ($user->role === 'admin' || $user->role === 'superadmin')) {
            return '/dashboard';
        }

        // Rediriger les utilisateurs standards vers la page d'accueil
        return '/';
    }
}