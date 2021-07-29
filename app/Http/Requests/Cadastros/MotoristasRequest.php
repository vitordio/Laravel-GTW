<?php

namespace App\Http\Requests\Cadastros;

use App\Rules\CPFValidation;
use Illuminate\Foundation\Http\FormRequest;

class MotoristasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'des_cpf' => ['required', 'max:11', new CPFValidation],
            'des_nome' => 'required|max:255',
            'des_rntrc' => 'required|max:8',
            'des_cnh' => 'max:255|nullable',

            // Dados complementares
            'dat_nascimento' => 'date_format:Y-m-d|before:today|nullable',
            'des_telefone' => 'max:10|nullable',
            'des_email' => 'email|max:60|nullable',

            // Endereço
            'des_cep' => 'required|max:9',
            'des_municipio' => 'required|max:60',
            'des_logradouro' => 'required|max:255',
            'des_numero' => 'required|max:60',
            'des_complemento' => 'max:60|nullable',
            'des_bairro' => 'required|max:60',
            
            // Conta bancária
            'id_banco' => 'exists:tb_cad_bancos,id|nullable',
            'des_agencia' => 'max:255|nullable',
            'des_conta' => 'max:14|nullable',
        ];
    }
}
