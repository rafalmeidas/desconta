<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class PessoaFormRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'nome' => 'required|min:3|max:45',
            'sobrenome' => 'required|min:3|max:45',
            'tipo_pessoa' => 'required|max:45',
            'cpf' => 'required|max:45',
            'data_nasc' => 'required',
            'tel_1' => 'required|min:3|max:45',
            'tel_2' => 'max:45',
            'rua' => 'required|min:3|max:45',
            'bairro' => 'required|min:3|max:45',
            'numero' => 'required|min:1|max:45',
            'cep' => 'required|min:1|max:45',
            'complemento' => 'min:1|max:45',
            'cidade_id' => 'required|min:1|exists:cidades,id'
        ];
    }

}
