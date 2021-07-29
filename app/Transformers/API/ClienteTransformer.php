<?php

namespace App\Transformers\API;

use App\Cliente;
use Flugg\Responder\Transformers\Transformer;

class ClienteTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param  \App\Cliente $cliente
     * @return array
     */
    public function transform(Cliente $cliente)
    {
        return [
            trans('labels.id') => (int) $cliente->id,
            trans('labels.des_cpf_cnpj') => $cliente->des_cpf_cnpj,
            trans('labels.des_inscricao_estadual') => $cliente->des_inscricao_estadual,
            trans('labels.des_nome') => $cliente->des_nome,
            trans('labels.des_login') => $cliente->des_login,
            trans('labels.des_telefone') => $cliente->des_telefone,
            trans('labels.des_email') => $cliente->des_email,
            trans('labels.flg_ativo') => $cliente->flg_ativo,
            trans('labels.endereco') => [
                trans('labels.des_cep') => $cliente->des_cep,
                trans('labels.des_uf') => $cliente->des_uf,
                trans('labels.des_municipio') => $cliente->des_municipio,
                trans('labels.des_logradouro') => $cliente->des_logradouro,
                trans('labels.des_numero') => $cliente->des_numero,
                trans('labels.des_complemento') => $cliente->des_complemento,
                trans('labels.des_bairro') => $cliente->des_bairro,
            ]
        ];
    }
}
