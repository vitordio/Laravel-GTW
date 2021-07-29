<?php

namespace App\Http\Requests\Configuracoes;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
        return  [
            'des_menu' => 'required|max:30',
            'des_icon' => 'required|max:30',
        ];
    }
}
