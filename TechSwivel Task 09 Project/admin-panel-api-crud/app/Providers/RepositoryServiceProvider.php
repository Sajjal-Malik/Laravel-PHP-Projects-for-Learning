<?php

namespace App\Providers;

use App\Repositories\Interfaces\API\AdminAuthRepositoryInterface;
use App\Repositories\Interfaces\API\ProfileApiRepositoryInterface;
use App\Repositories\Interfaces\Admin\ProfileAjaxRepositoryInterface;
use App\Repositories\Repository\API\AdminAuthRepository;
use App\Repositories\Repository\API\ProfileApiRepository;
use App\Repositories\Repository\Admin\ProfileAjaxRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
       $this->app->bind(AdminAuthRepositoryInterface::class, AdminAuthRepository::class);
       $this->app->bind(ProfileAjaxRepositoryInterface::class, ProfileAjaxRepository::class);
       $this->app->bind(ProfileApiRepositoryInterface::class, ProfileApiRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
