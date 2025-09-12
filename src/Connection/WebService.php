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


        $url = config('totvsrmsoap.url'). $path;

        $options = [
            'login'                 => config('totvsrmsoap.user'),
            'password'              => config('totvsrmsoap.pass'),
                        'authentication'        => 1,
            'soap_version'          => 1,
            'trace'                 => 1,
            'exceptions'            => 1, // Corrigido de 'excepitions' para 'exceptions' e definido como true
            "stream_context" => stream_context_create(
                [
                    'ssl' => [
                        'verify_peer'       => false,
                        'verify_peer_name'  => false,
                        'allow_self_signed' => true
                    ]
                ]
            )
        ];


        return $this->createSoapClient($url, $options);
    }

    /**
     * Método auxiliar para criar uma instância do SoapClient e tratar exceções.
     *
     * @param string $url URL completa do serviço SOAP.
     * @param array $options Opções para o SoapClient.
     * @return \SoapClient Instância do cliente SOAP.
     * @throws \RuntimeException Se houver um erro na conexão com o servidor SOAP.
     */
    private function createSoapClient(string $url, array $options): \SoapClient
    {
        try {
            return new \SoapClient($url, $options);
        } catch (\Exception $e) {
            $errorMessage = 'Erro: Não foi possível conectar ao servidor do RM. URL: ' . $url . ' - ' . $e->getMessage();
            error_log($errorMessage);
            throw new \RuntimeException($errorMessage, 0, $e);
        }
    }


}
