<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class Desconto extends Model
{
    protected $table = 'descontos';
    
    protected $fillable = [
        'pessoa_id', 
        'cpf',
        'compra_id',
        'valor_compra',
        'valor_desconto',
    ];
}