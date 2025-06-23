<?php

namespace mateusfbi\TotvsRmSoap\Services;

use TotvsRmSoap\Connection\WebService;


class Report
{
    private int $coligada;
    private int $id;
    private string $filtro;
    private string $parametros;
    private string $nomeArquivo;
    private string $contexto;
    private int $idReport;
    private $connection;

    public function __construct(WebService $ws)
    {
        $this->connection = $ws->getClient('/wsReport/MEX?wsdl');
    }

    /**
     * @param int $coligada
     * @return void
     */

    public function setColigada(int $coligada): void
    {
        $this->coligada = $coligada;
    }

    /**
     * @param int $id
     * @return void
     */

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $filtro
     * @return void
     */

    public function setFiltro(string $filtro): void
    {
        $this->filtro = $filtro;
    }

    /**
     * @param string $Parametros
     * @return void
     */

    public function setParametros(string $Parametros): void
    {
        $this->parametros = $Parametros;
    }

    /**
     * @param string $nomeArquivo
     * @return void
     */

    public function setNomeArquivo(string $nomeArquivo): void
    {
        $this->nomeArquivo = $nomeArquivo;
    }

    /**
     * @param string $contexto
     * @return void
     */

    public function setContexto(string $contexto): void
    {
        $this->contexto = $contexto;
    }

    /**
     * @return array
     */

    public function getReportList(): array
    {

        try {

            $execute = $this->connection->GetReportList([
                'codColigada' => $this->coligada
            ]);

            $result = str_replace('s:7625:"', '', $execute->GetReportListResult);

            $registros = explode(';,', $result);

            foreach ($registros as $registro) {
                $registro = trim($registro); // Remover espaços e quebras de linha
                if (empty($registro)) continue;
                // Dividir os campos por vírgula
                $campos = explode(',', $registro);
                // Mapear os campos (ajuste os índices conforme necessário)
                $dados = [
                    'coligada' => trim($campos[0]), // Exemplo: "0"
                    'sistema' => trim($campos[1]), // Exemplo: "TOTVS Folha de Pagamento"
                    'id' => trim($campos[2]), // Exemplo: "247"
                    'codigo' => trim($campos[3]), // Exemplo: "KITCONT"
                    'nome' => trim(implode(', ', array_slice($campos, 4, -2))), // Combina campos com vírgulas internas
                    'data' => trim($campos[count($campos) - 2]), // Penúltimo campo: data
                    'uuid' => trim($campos[count($campos) - 1]) // Último campo: UUID
                ];

                $return[] = $dados;
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        return $return;
    }


    /**
     * @return string
     */

    public function generateReport(): string
    {

        try {

            $execute = $this->connection->GenerateReport([
                'codColigada' => $this->coligada,
                'id'          => $this->id,
                'filters'     => $this->filtro,
                'parameters'  => $this->parametros,
                'fileName'    => $this->nomeArquivo,
                'contexto'    => $this->contexto,
            ]);

            $return = $execute->GenerateReportResult;
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        return $return;
    }

    /**
     * @return string
     */

    public function getReportMetaData(): string
    {

        try {

            $execute = $this->connection->GetReportMetaData([
                'codColigada' => $this->coligada,
                'id'      => $this->id
            ]);

            $return = $execute->GetReportMetaDataResponse;
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        return $return;
    }


    /**
     * @return string
     */

    public function getGeneratedReportStatus(): string
    {

        try {

            $execute = $this->connection->GetGeneratedReportStatus([
                'id'      => $this->id
            ]);

            $return = $execute->GetGeneratedReportStatusResult;
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        return $return;
    }

    /**
     * @return array
     */

    public function getReportInfo(): array
    {

        try {

            $execute = $this->connection->GetReportInfo([
                'codColigada'      => $this->coligada,
                'idReport'      => $this->idReport
            ]);

            $return = $execute->GetReportInfoResponse;
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }

        return $return;
    }
}
