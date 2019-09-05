<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = 'pessoas';
    
    protected $fillable = [
        'nome',
        'sobrenome',
        'tipo_pessoa',
        'cpf',
        'cnpj',
        'rg',
        'data_nasc',
        'tel_1',
        'tel_2',
        'rua',
        'bairro',
        'numero',
        'cep',
        'complemento',
        'cidade_id',
        'status'
    ];
    
    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }

    public function search($data, $totalPage)
    {
        $pessoas = $this->where(function ($query) use ($data) {

            if (isset($data['pesquisa']) && $data['pesquisa'] != null) {

                $query->where('cpf', $data['pesquisa']);
            }
        })->paginate($totalPage);
        return $pessoas;
    }
}
