<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $fillable = [
        'nr_parcela',
        'nr_boleto',
        'boleto_pago',
        'valor_parcela',
        'data_vencimento',
        'compra_id'
    ];

    public function compra(){
        return $this->belongsTo(Compra::class, 'compra_id');
    }
}
