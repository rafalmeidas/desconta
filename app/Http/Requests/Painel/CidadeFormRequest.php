<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class CidadeFormRequest extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'nome' => 'required|min:3|max:100',
            'estado_id' => 'required|min:1|exists:estados,id'
        ];
    }
}