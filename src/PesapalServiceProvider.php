<?php

namespace Bryceandy\Laravel_Pesapal;

use Bryceandy\Laravel_Pesapal\OAuth\OAuthSignatureMethod_HMAC_SHA1;
use Illuminate\Support\ServiceProvider;

class PesapalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/config/pesapal.php' => config_path('pesapal.php'),
            ], 'pesapal-config');
        }

        $this->loadResources();
    }

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
     * Loads resources
     */
    private function loadResources()
    {
        $this->app->singleton('Pesapal', fn($app) =>
            new \Bryceandy\Laravel_Pesapal\Pesapal(new OAuthSignatureMethod_HMAC_SHA1())
        );

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel_pesapal');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
}
