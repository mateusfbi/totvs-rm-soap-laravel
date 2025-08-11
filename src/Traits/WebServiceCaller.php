<?php

namespace mateusfbi\TotvsRmSoap\Traits;

use Exception;

trait WebServiceCaller
{
    /**
     * Método auxiliar para chamar métodos do serviço web e tratar exceções.
     *
     * @param string $methodName Nome do método a ser chamado no serviço web.
     * @param array $params Parâmetros a serem passados para o método.
     * @param mixed $defaultValue Valor padrão a ser retornado em caso de erro.
     * @return mixed O resultado da chamada do método ou o valor padrão em caso de exceção.
     */
    private function callWebServiceMethod(string $methodName, array $params = [], $defaultValue = null)
    {
        try {
            $execute = $this->webService->$methodName($params);
            $resultProperty = $methodName . 'Result';
            return $execute->$resultProperty;
        } catch (Exception $e) {
            error_log("Erro ao chamar o método SOAP '{$methodName}' na classe " . __CLASS__ . ": " . $e->getMessage());
            return $defaultValue;
        }
    }
}
