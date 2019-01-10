<?php

namespace Bryceandy\Laravel_Pesapal;


use Illuminate\Support\ServiceProvider;

class PesapalServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel_pesapal');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->publishes([
            __DIR__.'/config/pesapal.php' => config_path('pesapal.php'),
            __DIR__.'/resources/views/' => resource_path('views/pesapal'),
        ]);

        $this->publishes([
            __DIR__.'/assets' => public_path('pesapal'),
        ], 'public');

        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/Models' => app_path('/')
        ], 'models');

        $this->publishes([
            __DIR__.'/Http/Controllers' => app_path('/Http/Controllers')
        ], 'controllers');
    }

    public function register()
    {

        $this->mergeConfigFrom(__DIR__.'/config/pesapal.php', 'laravel_pesapal');

    }

}