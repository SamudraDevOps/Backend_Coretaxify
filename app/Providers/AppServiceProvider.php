<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        $this->app->register(\App\Providers\TelescopeServiceProvider::class);
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);

        // $this->app->bind(
        //     \App\Support\Interfaces\Repositories\InformasiUmumRepositoryInterface::class,
        //     \App\Repositories\InformasiUmumRepository::class
        // );

        // $this->app->bind(
        //     \App\Support\Interfaces\Services\InformasiUmumServiceInterface
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            $this->app['request']->server->set('HTTPS','on');
        }
    }
}
