<?php

namespace App\Providers;

use Illuminate\Database\Schema\Builder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        $this->app->make('db')->connection()->getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('boolean', 'integer');
    }
}
