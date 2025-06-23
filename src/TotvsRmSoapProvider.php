<?php

namespace mateusfbi\TotvsRmSoap;

use Illuminate\Support\ServiceProvider;

class TotvsRmSoapProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/totvsrmsoap.php' => config_path('totvsrmsoap.php')
        ],'config');
    }

    public function register()
    {

    }
}