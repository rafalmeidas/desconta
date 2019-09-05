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
    public function getEmpresa()
    {
        return  DB::select("SELECT * FROM empresas");
    }

    public function getEstado()
    {
        return  DB::select("SELECT * FROM estados");
    }
}
