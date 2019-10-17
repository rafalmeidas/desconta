<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $fillable = [
        'nr_parcela', 'nr_boleto', 'valor_parcela', 'compra_id'
    ];
}
