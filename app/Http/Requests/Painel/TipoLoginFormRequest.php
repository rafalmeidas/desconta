<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class TipoLoginFormRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {

        return [
            'descricao' => 'required|min:3|max:100',
            'sigla' => 'required|min:2|max:10',
        ];
    }

}
