# TotvsRmSoap

Este projeto é uma implementação em PHP para integração com o serviço SOAP da Totvs RM com o Framework Laravel.

## Requisitos

- PHP 8.0 ou superior
- Framework Laravel
- Extensão SOAP,XML do PHP
- Composer

## Instalação

1. Clone o repositório:
    ```sh
    git clone https://github.com/mateusfbi/totvs-rm-soap-laravel.git
    ```
2. Instale as dependências via Composer:
    ```sh
    composer install
    ```

## Configuração

1. Adicione e configure as variáveis de ambiente no arquivo `.env`. 

WS_URL="http://localhost:8051"
WS_USER="usuario"
WS_PASS="senha"

## Uso

Para utilizar o serviço SOAP, você pode instanciar os Services e chamar os métodos disponíveis. Veja um exemplo básico abaixo:

```php

use TotvsRmSoap\Connection\WebService;
use TotvsRmSoap\Services\DataServer;

    $ds =  new  DataServer(new WebService);
    $ds->setDataServer("GlbColigadaDataBR");
    $ds->setContexto("CODSISTEMA=G;CODCOLIGADA=0;CODUSUARIO=mestre");
    $ds->setFiltro("1=1");
    $result = $ds->readView();

    if(array_key_exists('GColigada',$result)){
        $result = $result['GColigada'];
    }else{
        $result = [];
    }

    dd($result);

```

## Licença

Este projeto está licenciado sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.