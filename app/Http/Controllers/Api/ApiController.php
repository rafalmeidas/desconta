<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;
use App\User;
use App\Models\Painel\Pessoa;
use App\Models\Painel\Estado;
use App\Models\Painel\Cidade;
use DB;

class ApiController extends Controller
{
    private $compra;
    private $user;
    private $pessoa;
    private $cidade;
    private $estado;

    public function __construct(Compra $compra, User $user, Pessoa $pessoa, Cidade $cidade, Estado $estado)
    {
        $this->compra = $compra;
        $this->user = $user;
        $this->pessoa = $pessoa;
        $this->cidade = $cidade;
        $this->estado = $estado;
    }



    //Empresas
    public function getCompra($id)
    {
        return  $this->compra->find($id);
    }


    public function getUsuarioComUid($uid)
    {
        $usuario = $this->user->where('uid_firebase' ,$uid)->first();
        if( $usuario != null)
        {
            $pessoa = $this->pessoa->find($usuario->empresa_id); // MODIFICAR DE EMPRESA PARA PESSOA

            return ApiController::retornoUsuario($usuario, $pessoa);
        } 
        return ApiController::retornoUsuario(new User, new Pessoa);
    }

    public function getUsuarioComCpf($cpf)
    {
        $pessoa = $this->pessoa->where('cpf' ,$cpf)->first();
        if( $pessoa != null)
        {
            return ApiController::retornoUsuario(new User, $pessoa);
        }
        return ApiController::retornoUsuario(new User, new Pessoa);
    }

    public function setUsuario(Request $request){
        $pessoa = new Pessoa;
        $params = $request->all();
    
        $pessoa->insert($params);
        $pessoa = $this->pessoa->where('cpf', $params['cpf'])->first();

        return ApiController::retornoUsuario(new User, $pessoa);
    }

    public function UpUsuario ($id, Request $request){
        $params = $request->all();
        $pessoa = Pessoa::find($id);
        $pessoa->update($params);
    }

    public function retornoUsuario(User $modelUser, Pessoa $modelPessoa){
        $modelUser = json_decode($modelUser);
        $modelPessoa = json_decode($modelPessoa);

        $retorno = "";
        if($modelUser != null){
            $retorno = '{
                "id": "' .$modelUser->id. '",
                "email": "' .$modelUser->email. '",
                "email_verified_at": "' .$modelUser->email_verified_at. '",';
        }else{
            $retorno = '{
                "id": "",
                "email": "",
                "email_verified_at": "",';
        }
        if($modelPessoa != null){

            $cidade = $this->cidade->find($modelPessoa->cidade_id);

            $estado = $this->estado->find($cidade->estado_id);

            $retorno .= '"pessoa": {
                "id": "' .$modelPessoa->id. '",
                "nome": "' .$modelPessoa->nome. '",
                    "sobrenome": "' .$modelPessoa->sobrenome. '",
                    "cpf": "' .$modelPessoa->cpf. '",
                    "rg": "' .$modelPessoa->rg. '",
                    "data_nasc": "' .$modelPessoa->data_nasc. '",
                    "tel_1": "' .$modelPessoa->tel_1. '",
                    "tel_2": "' .$modelPessoa->tel_2. '",
                    "rua": "' .$modelPessoa->rua. '",
                    "bairro": "' .$modelPessoa->bairro. '",
                    "numero": "' .$modelPessoa->numero. '",
                    "cep": "' .$modelPessoa->cep. '",
                    "complemento": "' .$modelPessoa->complemento. '",
                    "cidade": "' .$cidade->nome. '",
                    "estado": "' .$estado->sigla. '"
                }';
        }else{
            $retorno .= '"pessoa": {
                "id": "",
                "nome": "",
                    "sobrenome": "",
                    "cpf": "",
                    "rg": "",
                    "data_nasc": "",
                    "tel_1": "",
                    "tel_2": "",
                    "rua": "",
                    "bairro": "",
                    "numero": "",
                    "cep": "",
                    "complemento": "",
                    "cidade": "",
                    "estado": ""
                }';
        }

        $retorno .= '}';

        return $retorno;
    }
}