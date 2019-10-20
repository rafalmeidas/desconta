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
use PhpParser\Node\Param;

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

    public function getUsuarioComUid($uid)
    {
        $usuario = $this->user->where('uid_firebase' ,$uid)->first();
        if( $usuario != null)
        {
            $pessoa = $this->pessoa->find($usuario->pessoa_id); 
            return ApiController::retornoUsuario($usuario, $pessoa);
        }
        return ApiController::retornoUsuario(new User, new Pessoa);
    }

    public function getUsuarioComCpf($cpf)
    {
        $pessoa = $this->pessoa->where('cpf' ,$cpf)->first();
        if( $pessoa != null)
        {
            $usuario = $this->user->where('pessoa_id' ,$pessoa->id)->first();
            
            if($usuario != null) return response('Erro ao tentar criar novo usuário com o CPF fornecido', 417)
            ->header('Content-Type', 'text/plain');

            return ApiController::retornoUsuario(new User, $pessoa);
        }
        return ApiController::retornoUsuario(new User, new Pessoa);
    }

    public function setUsuario($email, $uid, Request $request){
        $pessoa = new Pessoa;
        $params = $request->all();
        $pessoa = $pessoa->insert($params);

        $pessoa = $this->pessoa->where('cpf' ,$params['cpf'])->first();

        $usuario = new User;
        $usuario->email = $email;
        $usuario->uid_firebase = $uid;
        $usuario->tipo_login = "Usuário"; 
        $usuario->status = true;
        $usuario->pessoa_id = $pessoa->id;
        $usuario->email_verified_at = null;
        $usuario->save();

        return ApiController::retornoUsuario($usuario, $pessoa);
    }

    public function UpUsuario ($id, $email, $uid, Request $request){
        $params = $request->all();
        $pessoa = Pessoa::find($id);
        $pessoa->nome = $params['nome'];
        $pessoa->sobrenome = $params['sobrenome'];
        $pessoa->rg = $params['rg'];
        $pessoa->data_nasc = $params['data_nasc'];
        $pessoa->tel_1 = $params['tel_1'];
        $pessoa->tel_2 = $params['tel_2'];
        $pessoa->rua = $params['rua'];
        $pessoa->bairro = $params['bairro'];
        $pessoa->numero = $params['numero'];
        $pessoa->cep = $params['cep'];        
        $pessoa->complemento = $params['complemento'];
        $pessoa->save();

        $usuario = new User;
        $usuario->email = $email;
        $usuario->uid_firebase = $uid;
        $usuario->tipo_login = "Usuário"; 
        $usuario->status = true;
        $usuario->pessoa_id = $id;
        $usuario->email_verified_at = null;
        $usuario->save();

        return ApiController::retornoUsuario($usuario, $pessoa);
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
        if($modelPessoa != null) {

            $cidade = $this->cidade->find($modelPessoa->cidade_id);
            $estado = null;
           
            if ($cidade != null) {
                $estado = $this->estado->find($cidade->estado_id);
            }

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
                    "complemento": "' .$modelPessoa->complemento. '"';
                    if ($cidade == null){
                        $retorno .= ',
                        " cidade": "",
                        "estado": ""';
                    }else{
                    $retorno .= ',
                    "cidade": "' .$cidade->nome. '",
                    "estado": "' .$estado->sigla. '"';
                    }
                $retorno .= '}';
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

    public function GetCompras($id)
    {
        $compra = $this->compra->where('pessoa_id' ,$id)->toSql();

        return  response()->json($compra);
    }

}