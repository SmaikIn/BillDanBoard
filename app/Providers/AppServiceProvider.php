<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\LaravelAuthService;
use App\Services\User\LaravelUserService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\JWTGuard;

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
        //

        $this->app->bind(JWTGuard::class, function () {
            return auth()->guard();
        });
        $this->app->singleton(AuthService::class, LaravelAuthService::class);

        $this->app->singleton(UserService::class, LaravelUserService::class);
    }
}
