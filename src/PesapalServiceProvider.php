<?php

namespace Bryceandy\Laravel_Pesapal;

use Bryceandy\Laravel_Pesapal\OAuth\OAuthSignatureMethod_HMAC_SHA1;
use Illuminate\Support\ServiceProvider;

class PesapalServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->registerPublishing();
        }

        $this->registerResources();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/pesapal.php', 'laravel_pesapal');
    }

    /**
     * Loads resources
     */
    private function registerResources()
    {
        $this->app->singleton('Pesapal', fn($app) =>
            new \Bryceandy\Laravel_Pesapal\Pesapal(new OAuthSignatureMethod_HMAC_SHA1())
        );

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel_pesapal');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Publishes resources when commands are initiated from the command line
     */
    private function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/config/pesapal.php' => config_path('pesapal.php'),
            //__DIR__.'/resources/views/' => resource_path('views/vendor/laravel_pesapal'),
            __DIR__.'/assets' => public_path('pesapal'),
        ]);
    }
}
