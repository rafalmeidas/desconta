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
        $usuario = json_decode($usuario);
        if( $usuario != null)
        {
            $pessoa = $this->pessoa->find($usuario->empresa_id); // MODIFICAR DE EMPRESA PARA PESSOA
            $pessoa = json_decode($pessoa); 

            $cidade = $this->cidade->find($pessoa->cidade_id);

            $estado = $this->estado->find($cidade->estado_id);

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
                    "cidade": "' .$cidade->nome. '",
                    "estado": "' .$estado->sigla. '"
                }
            }';
        }
        else {
            $pessoa_usuario = '{
                "id": "",
                "email": "",
                "email_verified_at": "",
                "pessoa": {
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
                }
            }';
        }
        return $pessoa_usuario;
    }

    public function getUsuarioComCpf($cpf)
    {
        $pessoa = $this->pessoa->where('cpf' ,$cpf)->first();
        $pessoa = json_decode($pessoa);
        if( $pessoa != null)
        {

            $cidade = $this->cidade->find($pessoa->cidade_id);

            $estado = $this->estado->find($cidade->estado_id);

            $pessoa_usuario = '{
                "id": "",
                "email": "",
                "email_verified_at": "",
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
                    "cidade": "' .$cidade->nome. '",
                    "estado": "' .$estado->sigla. '"
                }
            }';
        }
        else {
            $pessoa_usuario = '{
                "id": "",
                "email": "",
                "email_verified_at": "",
                "pessoa": {
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
                }
            }';
        }
        return $pessoa_usuario;
    }

    public function setUsuario(Request $request){
            $pessoa = new Pessoa;

        /*    $pessoa->nome = $request->input("nome");
            $pessoa->sobrenome = $request->input("sobrenome");
            $pessoa->tipo_pessoa = "Usuário";
            $pessoa->cpf = $request->input("cpf");
            $pessoa->cnpj = null;
            $pessoa->rg = $request->input("rg");
            $pessoa->data_nasc = $request->input("dataNasc");
            $pessoa->tel_1 = $request->input("telefone1");
            $pessoa->tel_2 = $request->input("telefone2");
            $pessoa->rua = $request->input("rua");
            $pessoa->bairro = $request->input("bairro");
            $pessoa->numero = $request->input("numero");
            $pessoa->cep = $request->input("cep");
            $pessoa->complemento = $request->input("complemento");
            $pessoa->cidade_id = 1;  //arrumar isso -- nao posso setar a cidade direto com id

            $pessoa->save();

            return response()->json($pessoa);
*/
        $arraydados  = $request->all();
        $pessoa->sobrenome = $arraydados['nome'];
            $pessoa->sobrenome = $arraydados['sobrenome'];
            $pessoa->tipo_pessoa = "Usuário";
            $pessoa->cpf = $arraydados['cpf'];
            $pessoa->cnpj = null;
            $pessoa->rg = $arraydados['rg'];
            $pessoa->data_nasc = $arraydados['dataNasc'];
            $pessoa->tel_1 = $arraydados['telefone1'];
            $pessoa->tel_2 = $arraydados['telefone2'];
            $pessoa->rua = $arraydados['rua'];
            $pessoa->bairro = $arraydados['bairro'];
            $pessoa->numero = $arraydados['numero'];
            $pessoa->cep = $arraydados['cep'];
            $pessoa->complemento = $arraydados['complemento'];
            $pessoa->cidade_id = 1;  //arrumar isso -- nao posso setar a cidade direto com id

            $pessoa->save();

            return response()->json($pessoa);
    }
}