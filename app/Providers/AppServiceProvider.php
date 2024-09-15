<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\LaravelAuthService;
use App\Services\Company\CompanyService;
use App\Services\Company\LaravelCompanyService;
use App\Services\Company\Repositories\CacheCompanyRepository;
use App\Services\Company\Repositories\CompanyRepository;
use App\Services\Department\DepartmentService;
use App\Services\Department\LaravelDepartmentService;
use App\Services\Department\Repositories\CacheDepartmentRepository;
use App\Services\Department\Repositories\DepartmentRepository;
use App\Services\Mail\LaravelMailService;
use App\Services\Mail\MailService;
use App\Services\Role\LaravelRoleService;
use App\Services\Role\Repositories\CacheRoleRepository;
use App\Services\Role\Repositories\RoleRepository;
use App\Services\Role\RoleService;
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

        $this->app->singleton(CompanyService::class, LaravelCompanyService::class);
        $this->app->singleton(CompanyRepository::class, CacheCompanyRepository::class);

        $this->app->singleton(UserService::class, LaravelUserService::class);
        $this->app->singleton(MailService::class, LaravelMailService::class);

        $this->app->singleton(RoleService::class, LaravelRoleService::class);
        $this->app->singleton(RoleRepository::class, CacheRoleRepository::class);

        $this->app->singleton(DepartmentService::class, LaravelDepartmentService::class);
        $this->app->singleton(DepartmentRepository::class, CacheDepartmentRepository::class);
    }
}
