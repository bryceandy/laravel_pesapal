<?php

namespace Bryceandy\Laravel_Pesapal;

use Bryceandy\Laravel_Pesapal\Http\Middleware\ValidateConfigMiddleware;
use Bryceandy\Laravel_Pesapal\OAuth\OAuthSignatureMethod_HMAC_SHA1;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class PesapalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/config/pesapal.php' => config_path('pesapal.php'),
            ], 'pesapal-config');
        }

        // Load middleware alias
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('config', ValidateConfigMiddleware::class);
        // Resources
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
     * Loads that are needed automatically
     */
    private function loadResources()
    {
        // Boot facade
        $this->app->singleton('Pesapal', fn($app) =>
            new \Bryceandy\Laravel_Pesapal\Pesapal(new OAuthSignatureMethod_HMAC_SHA1())
        );

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel_pesapal');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
}
