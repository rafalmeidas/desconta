<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class CompraFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'data_venda' => 'required|min:3|max:45',
            'qtde_parcelas' => 'required|min:3|max:45',
            'valor_total' => 'required|max:45',
            'empresa_id' => 'required|min:1|exists:empresas,id',
            'pessoa_id' => 'required|min:1|exists:pessoas,id'
        ];
    }
}
