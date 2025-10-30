<?php

namespace mateusfbi\TotvsRmSoap\Providers;

use Illuminate\Support\ServiceProvider;
use mateusfbi\TotvsRmSoap\Connection\WebService;
use mateusfbi\TotvsRmSoap\Services\ConsultaSQL;
use mateusfbi\TotvsRmSoap\Services\DataServer;
use mateusfbi\TotvsRmSoap\Services\FormulaVisual;
use mateusfbi\TotvsRmSoap\Services\Process;
use mateusfbi\TotvsRmSoap\Services\Report;
use mateusfbi\TotvsRmSoap\TotvsRM;

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
        $this->mergeConfigFrom(
            __DIR__.'/../config/totvsrmsoap.php', 'totvsrmsoap'
        );

        // Registra cada serviço individualmente (mantendo a compatibilidade)
        $this->app->singleton(WebService::class, fn() => new WebService());
        $this->app->singleton(DataServer::class, fn($app) => new DataServer($app->make(WebService::class)));
        $this->app->singleton(ConsultaSQL::class, fn($app) => new ConsultaSQL($app->make(WebService::class)));
        $this->app->singleton(Report::class, fn($app) => new Report($app->make(WebService::class)));
        $this->app->singleton(Process::class, fn($app) => new Process($app->make(WebService::class)));
        $this->app->singleton(FormulaVisual::class, fn($app) => new FormulaVisual($app->make(WebService::class)));

        // Registra a classe principal que a Facade irá usar
        $this->app->singleton('totvs-rm', function ($app) {
            return new TotvsRM(
                $app->make(DataServer::class),
                $app->make(ConsultaSQL::class),
                $app->make(Report::class),
                $app->make(Process::class),
                $app->make(FormulaVisual::class)
            );
        });
    }
}