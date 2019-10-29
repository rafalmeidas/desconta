<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model {
    protected $fillable = [
        'data_venda',
        'qtde_parcelas',
        'valor_total',
        'compra_paga',
        'empresa_id',
        'pessoa_id'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function pessoa(){
        return $this->belongsTo(Pessoa::class, 'pessoa_id');
    }
}
