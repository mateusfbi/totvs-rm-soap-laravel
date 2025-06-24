<?php

namespace mateusfbi\TotvsRmSoap\Connection;

use \SoapClient;

/**
 * Retorna uma instância do SoapClient configurada para o endpoint especificado.
 *
 * Este método constrói a URL do serviço concatenando a variável de ambiente WS_URL com o
 * caminho ($path) fornecido. Em seguida, cria e retorna uma instância do SoapClient
 * com as seguintes opções:
 * - 'login' e 'password': obtidos das variáveis de ambiente WS_USER e WS_PASS.
 * - Autenticação básica.
 * - Uso da versão SOAP 1.1.
 * - Ativação do trace para debugar a requisição.
 * - Configuração do stream context para lidar com conexões SSL sem verificação de peer.
 *
 * Em caso de erro na conexão, o método exibe uma mensagem de erro e encerra a execução.
 *
 * @param string $path Caminho relativo do serviço SOAP (parte do WSDL) a ser utilizado.
 * @return SoapClient Instância do cliente SOAP configurada para realizar as requisições.
 */

class WebService
{

   /**
     * @param string $path
     * @return SoapClient
     */

    public function getClient(string $path) : SoapClient
    {
        try {

            $connection = new SoapClient(config('totvsrmsoap.url'). $path, [
                    'login'                 => config('totvsrmsoap.user'),
                    'password'              => config('totvsrmsoap.pass'),
                    'authentication'        => SOAP_AUTHENTICATION_BASIC,
                    'soap_version'          => SOAP_1_1,
                    'trace'                 => 1,
                    'excepitions'           => 0,
                    "stream_context" => stream_context_create(
                        [
                        'ssl' => [
                                'verify_peer'       => false,
                                'verify_peer_name'  => false,
                                'allow_self_signed' => true
                        ]
                        ]
                    )
                ]);

        } catch (\Exception $e) {
            echo '<h2 style="color:red;"><br /><br /> Erro: Não foi possival conectar ao servidor do RM.' .' - '.config('totvsrmsoap.url'). '<br /></h2>'. $e->getMessage() . PHP_EOL;            
        }

        return $connection;
    }

}
