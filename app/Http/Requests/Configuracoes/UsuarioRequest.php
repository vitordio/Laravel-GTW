<?php

namespace App\Http\Requests\Configuracoes;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
        switch ($this->_method) {
            case 'POST':
                $validation = [
                    'des_email' => 'required|email|unique:tb_cad_usuario',
                    'des_nome'  => 'required|max:50',
                    'id_perfil_acesso' => 'required|integer',
                    'password' => 'min:6|required_with:password_confirmation|same:password_confirmation|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
				    'password_confirmation' => 'required',
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $validation = [
                    'des_email' => 'required|email|unique:tb_cad_usuario,des_email,'. $this->id,
                    'des_nome'  => 'required|max:50',
                    'id_perfil_acesso' => 'required|integer',
                ];
                
                if($this->password)
                {
                    $validation += [
                        'password' => 'min:6|required_with:password_confirmation|same:password_confirmation|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
				        'password_confirmation' => 'required',
                    ];
                }

                break;
            default:
                break;
        }

        return $validation;
    }
}
