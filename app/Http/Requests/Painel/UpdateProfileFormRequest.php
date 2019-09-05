<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $id = auth()->user()->id;

        return [
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255", //|unique:users, email, {$id}, id"
            'password' => 'max:20',
            'image' => 'image',
            'tipo_login' => 'string|max:255', 
            'empresa_id' => 'min:1|exists:empresas,id',
        ];
    }
}
