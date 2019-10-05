<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;
use App\User;
use App\Models\Painel\Pessoa;
use App\Models\Estado;
use DB;

class ApiController extends Controller
{
    private $compra;
    private $user;
    private $pessoa;

    public function __construct(Compra $compra, User $user, Pessoa $pessoa)
    {
        $this->compra = $compra;
        $this->user = $user;
        $this->pessoa = $pessoa;
    }

    //Empresas
    public function getCompra($id)
    {
        return  $this->compra->find($id);
    }


    public function getUsuario($uid)
    {
        $usuario = $this->user->where( 'uid_firebase' ,$uid)->first();
        $usuario = json_decode($usuario);
        if( $usuario != null)
        {
            $pessoa = $this->pessoa->find($usuario->empresa_id); // MODIFICAR DE EMPRESA PARA PESSOA
            $pessoa = json_decode($pessoa); 

            $pessoa_usuario = '{
                "id": "' .$usuario->id. '",
                "email": "' .$usuario->email. '",
                "email_verified_at": "' .$usuario->email_verified_at. '",
                "pessoa": {
                    "id": "' .$pessoa->id. '",
                    "nome": "' .$pessoa->nome. '",
                    "sobrenome": "' .$pessoa->sobrenome. '",
                    "cpf": "' .$pessoa->cpf. '",
                    "rg": "' .$pessoa->rg. '",
                    "data_nasc": "' .$pessoa->data_nasc. '",
                    "tel_1": "' .$pessoa->tel_1. '",
                    "tel_2": "' .$pessoa->tel_2. '",
                    "rua": "' .$pessoa->rua. '",
                    "bairro": "' .$pessoa->bairro. '",
                    "numero": "' .$pessoa->numero. '",
                    "cep": "' .$pessoa->cep. '",
                    "complemento": "' .$pessoa->complemento. '",
                    "cidade_id": "' .$pessoa->cidade_id. '"
                }
            }';

            return $pessoa_usuario;
        }
        return "";
    }

}