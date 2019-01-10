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
        ]);

    }

    public function register()
    {

        $this->mergeConfigFrom(__DIR__.'/config/pesapal.php', 'laravel_pesapal');

    }

}