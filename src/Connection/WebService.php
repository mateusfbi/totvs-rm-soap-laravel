<?php

namespace TotvsRmSoap\Connection;

use \SoapClient;
use Dotenv\Dotenv;

class WebService
{

   /**
     * @param string $path
     * @return SoapClient
     */

    public function getClient(string $path) : SoapClient
    {
        try {

            $connection = new SoapClient(env('WS_URL'). $path, [
                    'login'                 => env('WS_USER'),
                    'password'              => env('WS_PASS'),
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
            echo '<h2 style="color:red;"><br /><br /> Erro: Não foi possival conectar ao servidor do RM.' .' - '.env('WS_URL'). '<br /></h2>'. $e->getMessage() . PHP_EOL;
            exit;
        }

        return $connection;
    }

}
