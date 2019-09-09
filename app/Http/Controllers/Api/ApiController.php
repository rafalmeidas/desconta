<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ApiController extends Controller
{
    public function __construct()
    {
    }
    //Empresas
    public function getCompra()
    {
        return  DB::select("SELECT data_venda, valor_total, empresas.nome_fantasia
                                FROM  compras
                                INNER JOIN empresas on compras.empresa_id = empresas.id");
    }

    public function getEstado()
    {
        return  DB::select("SELECT * FROM estados");
    }
}