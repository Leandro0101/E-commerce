<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
            'nome'          => 'required|max:45',
            'email'         => 'required|max:45|unique:clientes,email|email',
            'senha'         => 'required|min:8',
            'confSenha'     => 'same:senha',
            'fotoCliente'   => 'image'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'max'      => 'O campo :attribute aceita no máximo :max caracteres',
            'min'      => 'O campo :attribute aceita no mínimo :min caracteres',
            'unique'   => ':attribute já cadastrado',
            'same'     => 'As senhas não são iguais',
            'image'    => 'Imagem inválida',
            'email'    => 'Email inválido'
        ];
    }
}
