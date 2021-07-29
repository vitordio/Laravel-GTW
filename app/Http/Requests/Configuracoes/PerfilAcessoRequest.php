<?php

namespace App\Http\Requests\Configuracoes;

use Illuminate\Foundation\Http\FormRequest;

class PerfilAcessoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'des_perfil' => 'required|max:20',
            'des_descricao_perfil' => 'required|max:50'
        ];
    }
}
