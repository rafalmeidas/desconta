<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;
use App\User;
use App\Models\Painel\Pessoa;
use App\Models\Painel\Estado;
use App\Models\Painel\Cidade;
use App\Models\Painel\Empresa;
use App\Models\Painel\Parcela;
use DB;

class ApiController extends Controller
{
    private $compra;
    private $user;
    private $pessoa;
    private $cidade;
    private $estado;
    private $empresa;
    private $parcela;

    public function __construct(Compra $compra, User $user, Pessoa $pessoa, Cidade $cidade, Estado $estado, Empresa $empresa, Parcela $parcela)
    {
        $this->compra = $compra;
        $this->user = $user;
        $this->pessoa = $pessoa;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->empresa = $empresa;
        $this->parcela = $parcela;
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


    public function GetEmpresas($id){

        $empresa = DB::select("SELECT empresas.id, empresas.razao_social, empresas.nome_fantasia, empresas.cnpj, empresas.inscricao_est,
                                    empresas.porcentagem_desc, empresas.tel, empresas.rua, empresas.bairro, empresas.numero, empresas.cep, 
                                    empresas.complemento, empresas.cidade_id, empresas.status
                                FROM empresas, compras
                                WHERE compras.pessoa_id = $id
                                AND empresas.id = compras.empresa_id
                                GROUP BY empresas.id; "
                             );

        return  response()->json($empresa);
    }

    public function GetCompras($idUsuario, $idEmpresa)
    {

        $compra = DB::select("SELECT compras.id, data_venda, qtde_parcelas, valor_total, nome_fantasia
                               FROM compras, empresas
                               WHERE compras.empresa_id  = empresas.id
                               AND empresas.id = $idEmpresa
                               AND pessoa_id = $idUsuario;"
                            );

        return  response()->json($compra);
    }

    public function GetParcelas($idCompra)
    {

        $parcela = DB::select("SELECT id, nr_parcela, nr_boleto, valor_parcela, boleto_pago
                                FROM public.parcelas
                                where compra_id = $idCompra
                                ORDER BY boleto_pago = 'S';"
                            );
        

        return  response()->json($parcela);
    }

    //compra = id, data_venda, qtde_parcelas, valor_total, 
    //parcelas = id, nr_parcela, nr_boleto, valor_parcela
    //empresa_id(id, razao social, nome fantasia, cnpj, telefone,  endereço completo)


    public function PagarParcela($idParcela){
        $parcela = Parcela::find($idParcela);
       // $params = $request->all();
        $parcela->boleto_pago = 'S'; //$params['boleto_pago'];

        $retorno = $parcela->save();
       
        if($retorno){
            return response('Compra paga com sucesso ', 200)
            ->header('Content-Type', 'text/plain');
        }
    }
}