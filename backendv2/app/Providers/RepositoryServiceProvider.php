<?php

namespace App\Providers;

use App\Repositories\JustificationRepositories\EloquentJustificationRepository;
use App\Repositories\ProfileRepositories\EloquentPositionRepository;
use App\Repositories\UserRepositories\EloquentUserRepository;
use App\Repositories\JustificationRepositories\JustificationRepositoryInterface;
use App\Repositories\ProfileRepositories\PositionRepositoryInterface;
use App\Repositories\UserRepositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, EloquentPositionRepository::class);
        $this->app->bind(JustificationRepositoryInterface::class, EloquentJustificationRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
