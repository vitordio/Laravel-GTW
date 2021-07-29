<?php

namespace App\Http\Requests\Cadastros;

use App\Components\Biblioteca;
use App\Models\Cadastros\Clientes;
use App\Rules\CepValidation;
use App\Rules\CNPJValidation;
use App\Rules\CPFValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientesRequest extends FormRequest
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
        $validation = [
            'des_inscricao_estadual'  => ['max:14', 'required_if:tipo_cliente,' . Clientes::CNPJ],
            'des_nome'  => 'required|max:60',
            'des_nome_fantasia'  => ['max:60', 'required_if:tipo_cliente,' . Clientes::CNPJ],
            'des_divisao' => 'max:70',
            'des_telefone' => 'max:10',
            'des_email' => 'email|max:60',
            'des_login' => 'required|unique:tb_cad_clientes',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required',
            'id_tipo_atividade' => 'required|exists:tb_cad_tipo_atividade,id',
            'des_cep' => ['required', 'max:9'],
            // 'des_cep' => ['required', 'max:9', new CepValidation],
            'des_municipio' => 'required|max:60',
            'des_logradouro' => 'required|max:255',
            'des_numero' => 'required|max:60',
            'des_complemento' => 'max:60',
            'des_bairro' => 'required|max:60' 
        ];

        /** Stwitch para verificação do método para validação dos dados de acesso */
        switch ($this->_method) {
            case 'PUT':
            case 'PATCH':
                $validation['des_login'] = 'required|unique:tb_cad_clientes,des_login,' . $this->id;
                
                if($this->password)
                {
                    $validation['password'] = 'min:6|required_with:password_confirmation|same:password_confirmation|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/';
                    $validation['password_confirmation'] = 'required';
                } else {
                    $validation['password'] = '';
                    $validation['password_confirmation'] = '';
                }
                break;
            default:
                break;
        }

        /* Foreach em cada campo de e-mail alternativo */
        if($this->request->get('emailsAlternativos'))
        {
            foreach ($this->request->get('emailsAlternativos') as $key => $email) {
                $validation['emailsAlternativos.'.$key] = 'email|max:60'; // o laravel mapeia o 'emailsAlternativos.$key' para emailsAlternativos[$key]
            }
        }

        /**
         * O campo CPF/CNPJ é obrigatório, deve ser válido e não pode se repetir,
         * a menos que o campo divisão tenha sido preenchido e não esteja igual a outro registro
        */
        $validation['des_cpf_cnpj'] = [Rule::unique('tb_cad_clientes')->where(function($query) {
            if($this->request->has('des_divisao'))
                $query->where('des_divisao', $this->request->all()['des_divisao']);
            
            $query->where('des_cpf_cnpj', $this->request->all()['des_cpf_cnpj']);
            
            if(in_array($this->_method, [Biblioteca::METHOD_UPDATE, Biblioteca::METHOD_PUT]))
                $query->whereNotIn('id', [$this->request->all()['id']]);

        })];

        if($this->request->all()['tipo_cliente'] == Clientes::CPF)
        {
            array_push($validation['des_cpf_cnpj'], 'required', 'max:11', new CPFValidation); 
        } else {
            array_push($validation['des_cpf_cnpj'], 'required', 'max:15', new CNPJValidation); 
        }

        return $validation;
    }

    /**
     * Prepara o dado antes da validação
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'des_cpf_cnpj' => Biblioteca::removeMasks($this->des_cpf_cnpj),
            'des_telefone' => Biblioteca::removeMasks($this->des_telefone),
            'des_cep' => Biblioteca::removeMasks($this->des_cep),
        ]);
    }

    /** Passamos o message para ajustar a mensagem de erro dos emails alternativos */
    public function messages()
    {
        $messages = [];
        if($this->request->get('emailsAlternativos'))
        {
            foreach($this->request->get('emailsAlternativos') as $key => $email)
            {
                $messages['emailsAlternativos.'.$key.'.max'] = 'O campo E-mail alternativo não deve ter mais que :max caracteres.';
                $messages['emailsAlternativos.'.$key.'.email'] = 'O campo E-mail alternativo deve ser um e-mail válido.';
            }
        }

        return $messages;
    }
}
