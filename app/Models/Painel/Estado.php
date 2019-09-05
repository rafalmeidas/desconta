<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model {
    protected $table = 'estados';
    
    protected $fillable = [
        'nome', 'sigla', 'status'
    ];
}
