<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
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
            'nome'      => 'required|max:30|unique:categorias,nome',
            'descricao' => 'required|min:8|max:90'
        ];
    }

    public function messages(){
        return [
            'required' => 'O campo :attribute é obrigatório ',
            'max'      => 'É permitido no máximo :max caracteres nesse campo',
            'min'      => 'É permitido no mínimo :minx caracteres nesse campo',
            'unique'   => 'Nome em uso',
        ];
    }
}
