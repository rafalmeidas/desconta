<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;
use App\Models\Painel\Desconto;

class AdminController extends Controller {

    public function index() {
        $titulo = 'Home';
        $compra = new Compra();
        $desconto = new Desconto();
        $compras =  $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)->get();
        $qtdeCompras = $compra->where('compras.empresa_id', '=', auth()->user()->empresa_id)->count();
        $query = null;
        //consulta dos descontos
        foreach($compras as $d){
            $query[] = $desconto->where('compra_id', '=', $d->id)->get();   
        }
        
        //Calculando os descontos
        $qtdeDescontos = null;
        foreach($query as $q){
            foreach($q as $des)
            $qtdeDescontos += (int) $des->valor_desconto;
        }

        return view('admin.home.index', compact('titulo', 'qtdeCompras', 'qtdeDescontos'));
    }

}
