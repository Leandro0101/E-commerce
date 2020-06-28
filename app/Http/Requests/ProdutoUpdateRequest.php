<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoUpdateRequest extends FormRequest
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
            'nomeUp'      => 'required|max:40',
            'preco'     => 'required|numeric',
            'descricao' => 'required|max:300|min:85',
            'fotos.*'   => 'image|max: 2160',
        ];
    }

    public function messages(){
        return [
            'required' => 'Este campo é obrigatório',
            'image'    => 'Imagem inválida',
            'max'      => 'Este campo aceita no máximo :max caracteres',
            'min'      => 'Este campo aceita no mínimo :min caracteres',
            'numeric'  => 'Só é permitido valores numéricos',
            'fotos.*.max'     => 'Imagem não suportada. Máximo: 2mb'
        ];
    }

}
