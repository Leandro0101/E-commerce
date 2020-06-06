<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
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
            'nome'      => 'required|unique:produtos,nome|max:40',
            'preco'     => 'required|numeric',
            'descricao' => 'required|max:70|min:7',
            'fotos.*'   => 'image'
        ];
    }

    public function messages(){
        return [
            'required' => 'O campo :attribute é obrigatório',
            'unique'   => ':attribute já em uso',
            'image'    => 'Imagem inválida',
            'max'      => 'Este campo aceita no máximo :max caracteres',
            'min'      => 'Este campo aceita no mínimo :min caracteres',
            'numeric'  => 'Só é permitido valores numéricos'
        ];
    }
}
