<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CpoRepository;
use App\Repositories\CpoRepositoryInterface;
use App\Repositories\CpoLineRepository;
use App\Repositories\CpoLineRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
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
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
