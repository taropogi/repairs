<?php

namespace App\Providers;

use App\Repositories\CpoRepository;
use App\Repositories\CpoRepositoryInterface;
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
