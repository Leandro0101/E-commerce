<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtualizacaoClienteRequest extends FormRequest
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
            'nome'          => 'required',
            'email'         => 'email|required',
            'senhaNova'     => 'max:50',
            'fotoCliente'   => 'image',
            'confSenhaNova' => 'same:senhaNova'
        ];
    }

    public function messages(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'email'    => 'Email inválido',
            'min'      => 'Senha muito curta',
            'max'      => 'Senha muito longa',
            'image'    => 'Imagem inválida',
            'same'     => 'As senhas não correspondem'
        ];
    }
}
