<?php

namespace Bryceandy\Laravel_Pesapal;


use Illuminate\Support\ServiceProvider;

class PesapalServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel_pesapal');

    }

    public function register()
    {



    }

}