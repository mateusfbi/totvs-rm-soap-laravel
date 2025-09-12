# TotvsRmSoap

Este projeto é uma implementação em PHP para integração com o serviço SOAP da Totvs RM com o Framework Laravel.

## Requisitos

- PHP 8.0 ou superior
- Framework Laravel
- Extensão SOAP,XML do PHP
- Composer

## Instalação
Instale o pacote via Composer:
```bash
composer require mateusfbi/totvs-rm-soap-laravel
```

Em seguida, publique o arquivo de configuração:
```bash
php artisan vendor:publish --provider="mateusfbi\TotvsRmSoap\Providers\TotvsRmSoapProvider" --tag="config"
```

## Configuração

Adicione e configure as variáveis de ambiente no arquivo `.env`.
```
TOTVSRM_WSURL=http://localhost:8051
TOTVSRM_USER=usuario
TOTVSRM_PASS=senha
```

## Uso

Você pode utilizar a Facade `TotvsRM` para acessar os serviços, ou injetar as classes de serviço diretamente em seus controllers.

### Exemplo com a Facade `TotvsRM`

A facade `TotvsRM` provê acesso a todos os serviços disponíveis:

- `dataServer()`
- `consultaSQL()`
- `report()`
- `process()`
- `formulaVisual()`

```php
use mateusfbi\TotvsRmSoap\Facades\TotvsRM;

// Exemplo de uso do serviço DataServer através da Facade
$ds = TotvsRM::dataServer();
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
```

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

## Licença

Este projeto está licenciado sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.
