<?php

namespace App\Models\Painel;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model {
    protected $table = 'empresas';
    
    protected $fillable = [
        'razao_social', 
        'nome_fantasia',
        'cnpj',
        'inscricao_est',
        'tel',
        'rua',
        'bairro',
        'numero',
        'cep',
        'complemento',
        'cidade_id',
        'status'
    ];
    
    
    public function cidade(){
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }
}
