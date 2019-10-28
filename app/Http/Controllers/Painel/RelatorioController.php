<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;

class RelatorioController extends Controller
{
    public function relatorioCompra() {
        $compra = new Compra();
        $relatorio = $compra->all();

        dd($relatorio);
    }
}
