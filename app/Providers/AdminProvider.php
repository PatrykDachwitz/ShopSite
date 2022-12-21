<?php

namespace App\Providers;

use App\Repository\Admin\Eloquent\BannerRepository;
use App\Repository\Admin\BannerRepository as BannerRepositoryInteface;
use Illuminate\Support\ServiceProvider;

class AdminProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            BannerRepositoryInteface::class,
            BannerRepository::class
        );
    }
}
