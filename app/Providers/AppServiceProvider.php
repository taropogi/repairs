<?php

namespace App\Providers;

use App\Repositories\CpoRepository;
use App\Repositories\CpoRepositoryInterface;
use App\Repositories\CpoLineRepository;
use App\Repositories\CpoLineRepositoryInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the CpoRepositoryInterface to the CpoRepository
        $this->app->bind(
            CpoRepositoryInterface::class,
            CpoRepository::class
        );

        // Bind the CpoLineRepositoryInterface to the CpoLineRepository
        $this->app->bind(
            CpoLineRepositoryInterface::class,
            CpoLineRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
