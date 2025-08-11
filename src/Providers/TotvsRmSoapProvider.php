<?php

namespace mateusfbi\TotvsRmSoap\Providers;

use Illuminate\Support\ServiceProvider;
use mateusfbi\TotvsRmSoap\Connection\WebService;
use mateusfbi\TotvsRmSoap\Services\ConsultaSQL;
use mateusfbi\TotvsRmSoap\Services\DataServer;
use mateusfbi\TotvsRmSoap\Services\FormulaVisual;
use mateusfbi\TotvsRmSoap\Services\Process;
use mateusfbi\TotvsRmSoap\Services\Report;

class TotvsRmSoapProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/totvsrmsoap.php' => config_path('totvsrmsoap.php')
        ],'config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/totvsrmsoap.php', 'totvsrmsoap'
        );
    }

    public function register()
    {
        $this->app->singleton(WebService::class, function ($app) {
            return new WebService();
        });

        $this->app->bind('totvs.consulta_sql', function ($app) {
            return new ConsultaSQL($app->make(WebService::class));
        });

        $this->app->bind('totvs.data_server', function ($app) {
            return new DataServer($app->make(WebService::class));
        });

        $this->app->bind('totvs.formula_visual', function ($app) {
            return new FormulaVisual($app->make(WebService::class));
        });

        $this->app->bind('totvs.process', function ($app) {
            return new Process($app->make(WebService::class));
        });

        $this->app->bind('totvs.report', function ($app) {
            return new Report($app->make(WebService::class));
        });
    }
}
