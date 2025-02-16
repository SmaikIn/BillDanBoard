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
use App\Services\Permission\LaravelPermissionService;
use App\Services\Permission\PermissionService;
use App\Services\Permission\Repositories\CachePermissionRepository;
use App\Services\Permission\Repositories\PermissionRepository;
use App\Services\Profile\LaravelProfileService;
use App\Services\Profile\ProfileService;
use App\Services\Profile\Repositories\CacheProfileRepository;
use App\Services\Profile\Repositories\ProfileRepository;
use App\Services\Role\LaravelRoleService;
use App\Services\Role\Repositories\CacheRoleRepository;
use App\Services\Role\Repositories\RoleRepository;
use App\Services\Role\RoleService;
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

        $this->app->singleton(RoleService::class, LaravelRoleService::class);
        $this->app->singleton(RoleRepository::class, CacheRoleRepository::class);

        $this->app->singleton(DepartmentService::class, LaravelDepartmentService::class);
        $this->app->singleton(DepartmentRepository::class, CacheDepartmentRepository::class);

        $this->app->singleton(ProfileService::class, LaravelProfileService::class);
        $this->app->singleton(ProfileRepository::class, CacheProfileRepository::class);

        $this->app->singleton(PermissionService::class, LaravelPermissionService::class);
        $this->app->singleton(PermissionRepository::class, CachePermissionRepository::class);
    }
}
