<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaFormRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'razao_social' => 'required|min:3|max:45',
            'nome_fantasia' => 'required|min:3|max:45',
            'cnpj' => 'required|max:45',
            'inscricao_est' => 'required',
            'tel' => 'required|min:3|max:45',
            'rua' => 'required|min:3|max:45',
            'bairro' => 'required|min:3|max:45',
            'numero' => 'required|min:1|max:45',
            'cep' => 'required|min:1|max:45',
            'complemento' => 'min:1|max:45',
            'cidade_id' => 'required|min:1|exists:cidades,id'
        ];
    }

}
