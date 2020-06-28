<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnderecoRequest extends FormRequest
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
            'bairro'     => 'required|max:60',
            'endereco'   => 'required|max:100',
            'numero'     => 'required|max:5|',
            'complemento'=> 'max:80',
            'cep'        => 'required',
            'estado'     => 'required',
            'cidade'     => 'required',
        ];
    }

    public function messages(){
        return [
            'required' => 'Este campo é obrigatório',
            'max'      => 'Este campo aceita no máximo :max caracteres'
        ];
    }
}
