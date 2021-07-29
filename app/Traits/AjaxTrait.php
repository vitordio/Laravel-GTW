<?php
namespace App\Traits;

use App\Models\Configuracoes\Log;
use Exception;
use Illuminate\Support\Facades\Auth;

trait AjaxTrait {

    /**
     * Função para chamar a API externa para consultar dados
     * da pessoa ou empresa pelo CPF ou CNPJ
     * 
     * @param $cpfCnpj
     * @return \Illuminate\Http\Response
     */
    public function apiCpfCnpj($cpfCnpj)
    {
        try
        {
            // Configuramos os parâmetros a serem substituídos no endPoint
            $endPoint = config('cpfCnpj.endPointAPI');
            $configParams = [
                '{token}'   => config('cpfCnpj.token'),
                '{pacote}'  => $this->isCpf($cpfCnpj) ? config('cpfCnpj.pacoteCPF') : config('cpfCnpj.pacoteCNPJ'),
                '{cpfcnpj}' => $this->onlyNumbersCpfCnpj($cpfCnpj)
            ];

            $urlApi = strtr($endPoint, $configParams);
            $urlFixaCpf = 'https://api.cpfcnpj.com.br/5ae973d7a997af13f0aaf2bf60e65803/8/00000000000';
            $urlFixaCnpj = 'https://api.cpfcnpj.com.br/5ae973d7a997af13f0aaf2bf60e65803/6/27272134000118/0';

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $urlFixaCpf,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));
    
            $response = curl_exec($curl);
            curl_close($curl);
            $result = json_decode($response);

            // Adicionamos o log pela consulta realizada
            $this->addToLog($result, $cpfCnpj);

            return $result;

        } catch(Exception $e)
        {
            throw $e;
        }
    }

    protected function isCpf($cpfCnpj) {
        return strlen($this->onlyNumbersCpfCnpj($cpfCnpj)) <= 11 ? true : false;
    }

    protected function onlyNumbersCpfCnpj($cpfCnpj) {
        return preg_replace('/[^0-9]/', '', $cpfCnpj);
    }

    protected function addToLog($retornoApi, $cpfCnpj) {
        $statusRetorno = isset($retornoApi->erro)
                            ? " retornando o status de erro: " . $retornoApi->erro
                            : " retornando status de consulta realizada com sucesso";

        // Faz a inserção do novo log
        $log = new Log([
            'des_acao' => "Usuário " . Auth::user()->des_nome .
            " realizou uma consulta no CPF/CNPJ " . $cpfCnpj .
            $statusRetorno
        ]);

        $log->save();
    }
}