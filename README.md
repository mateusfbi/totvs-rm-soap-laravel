# TotvsRmSoap

Este projeto é uma implementação em PHP para integração com o serviço SOAP da Totvs RM com o Framework Laravel.

## Requisitos

- PHP 8.0 ou superior
- Framework Laravel
- Extensão SOAP,XML do PHP
- Composer

## Instalação
Instale as dependências via Composer:
```composer install mateusfbi/totvs-rm-soap-laravel```

publicar o arquivo de configuração no diretório config
```php artisan vendor:publish --tag=config```

## Configuração

1. Adicione e configure as variáveis de ambiente no arquivo `.env`.
- TOTVSRM_WSURL=http://localhost:8051
- TOTVSRM_USER=usuario
- TOTVSRM_PASS=senha

## Uso

Para utilizar os serviços, você pode injetar as classes de serviço diretamente em seus controllers ou outros serviços, ou usar o helper `app()` do Laravel. O provedor de serviços se encarregará de instanciar as classes com suas dependências.

### Exemplo com Injeção de Dependência

```php
use Illuminate\Routing\Controller;
use mateusfbi\TotvsRmSoap\Services\DataServer;

class MeuController extends Controller
{
    public function buscarDados(DataServer $ds)
    {
        $ds->setDataServer("GlbColigadaDataBR");
        $ds->setContexto("CODSISTEMA=G;CODCOLIGADA=0;CODUSUARIO=mestre");
        $ds->setFiltro("1=1");
        $result = $ds->readView();

        if (array_key_exists('GColigada', $result)) {
            $result = $result['GColigada'];
        } else {
            $result = [];
        }

        dd($result);
    }
}
```

### Exemplo com o helper `app()`

Você também pode obter uma instância de um serviço usando os aliases registrados:

- `totvs.consulta_sql`
- `totvs.data_server`
- `totvs.formula_visual`
- `totvs.process`
- `totvs.report`

```php
$ds = app('totvs.data_server');
$ds->setDataServer("GlbColigadaDataBR");
$ds->setContexto("CODSISTEMA=G;CODCOLIGADA=0;CODUSUARIO=mestre");
$ds->setFiltro("1=1");
$result = $ds->readView();

// ...
```

## Licença

Este projeto está licenciado sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.