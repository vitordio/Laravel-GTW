<?php
namespace App\Components;

use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Biblioteca
{
    const METHOD_DELETE = '\DELETE';
    const METHOD_UPDATE = 'PATCH';
    const METHOD_PUT = 'PUT';
    const METHOD_POST = 'POST';
    const METHOD_SHOW = 'SHOW';

    const FLG_ATIVO = 'S';
    const FLG_DESATIVO = 'N';

    const MODELO_PADRAO = 'Padrão';
    const ID = 'id';

    const AMBIENTE_DSV = 'DSV';
    
    /** Ações do Sistema */
    const ACTION_CRIAR = 'Criar';
    const ACTION_VISUALIZAR = 'Visualizar';
    const ACTION_EDITAR = 'Editar';
    const ACTION_EXCLUIR = 'Excluir';
    const ACTION_GERAR_RELATORIO = 'Gerar Relatório';

    public static function desencriptar($id)
    {
        try 
        {
            $id = Crypt::decryptString($id);    
        } 
        catch (DecryptException $e) 
        {
            $id = '';
        }

        return $id;
    }

    /**
     * 
     * Generate v4 UUID
     * 
     * Version 4 UUIDs are pseudo-random.
     */
    public static function v4() 
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * Remove as máscaras
    */
    public static function removeMasks($inputValue)
    {
        $valueWithoutMask = trim($inputValue);
        $valueWithoutMask = str_replace(['.', ',', '-', '/', '(', ')', ' '], ['', '', '', '', '', '', ''], $valueWithoutMask);

        return $valueWithoutMask;
    }   
    
    /**
     * Função para retornar as UFs do Brasil
     * chamando a API do IBGE
    */
    public static function getUfsIBGE()
    {
        try
        {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => config('ibge.endPointEstados'),
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

            return $result;

        } catch(Exception $e)
        {
            throw $e;
        }
    }

    /**
     * Função para retornar os países
     * chamando a API do IBGE
    */
    public static function getPaisesIBGE()
    {
        try
        {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => config('ibge.endPointPaises'),
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

            if($result)
                return $result;

            return [];

        } catch(Exception $e)
        {
            throw $e;
        }
    }

    /**
     * Função para retornar os
     * municípios por UF
     */
    public static function getMunicipiosPorUF($uf)
    {
        $endPoint = config('ibge.endPoinMunicipiosPorUF');
        $endPointMunicipio = str_replace('{UF}', $uf, $endPoint);

        try
        {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $endPointMunicipio,
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

            return $result;

        } catch(Exception $e)
        {
            throw $e;
        }
    }
}