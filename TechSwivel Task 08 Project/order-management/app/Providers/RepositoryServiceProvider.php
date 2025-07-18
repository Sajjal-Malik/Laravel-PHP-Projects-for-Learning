<?php

namespace App\Providers;

use App\Repositories\Interfaces\FirestoreRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\UserManagementRepositoryInterface;
use App\Repositories\Repository\FirestoreRepository;
use App\Repositories\Repository\OrderRepository;
use App\Repositories\Repository\UserManagementRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserManagementRepositoryInterface::class, UserManagementRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(FirestoreRepositoryInterface::class, FirestoreRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
