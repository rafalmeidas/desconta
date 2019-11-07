<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;
use App\User;
use App\Models\Painel\Pessoa;
use App\Models\Painel\Estado;
use App\Models\Painel\Cidade;
use App\Models\Painel\Desconto;
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
    private $desconto;

    public function __construct(Compra $compra, User $user, Pessoa $pessoa, Cidade $cidade, Estado $estado, Empresa $empresa, Parcela $parcela, Desconto $desconto)
    {
        $this->compra = $compra;
        $this->user = $user;
        $this->pessoa = $pessoa;
        $this->cidade = $cidade;
        $this->estado = $estado;
        $this->empresa = $empresa;
        $this->parcela = $parcela;
        $this->desconto = $desconto;
    }

    public function getUsuarioComUid($uid)
    {
        $usuario = $this->user->where('uid_firebase', $uid)->first();
        if ($usuario != null) {
            $pessoa = $this->pessoa->find($usuario->pessoa_id);
            return ApiController::retornoUsuario($usuario, $pessoa);
        }
        return ApiController::retornoUsuario(new User, new Pessoa);
    }

    public function getUsuarioComCpf($cpf)
    {
        $pessoa = $this->pessoa->where('cpf', $cpf)->first();
        if ($pessoa != null) {
            $usuario = $this->user->where('pessoa_id', $pessoa->id)->first();

            if ($usuario != null) return response('Erro ao tentar criar novo usuário com o CPF fornecido', 417)
                ->header('Content-Type', 'text/plain');

            return ApiController::retornoUsuario(new User, $pessoa);
        }
        return ApiController::retornoUsuario(new User, new Pessoa);
    }

    public function setUsuario($email, $uid, Request $request)
    {
        $pessoa = new Pessoa;
        $params = $request->all();
        $pessoa = $pessoa->insert($params);

        $pessoa = $this->pessoa->where('cpf', $params['cpf'])->first();

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

    public function UpUsuario($id, $email, $uid, Request $request)
    {
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
        $pessoa->cidade_id = $params['cidade_id'];
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

    public function retornoUsuario(User $modelUser, Pessoa $modelPessoa)
    {
        $modelUser = json_decode($modelUser);
        $modelPessoa = json_decode($modelPessoa);

        $retorno = "";
        if ($modelUser != null) {
            $retorno = '{
                "id": "' . $modelUser->id . '",
                "email": "' . $modelUser->email . '",
                "email_verified_at": "' . $modelUser->email_verified_at . '",';
        } else {
            $retorno = '{
                "id": "",
                "email": "",
                "email_verified_at": "",';
        }
        if ($modelPessoa != null) {

            $cidade = $this->cidade->find($modelPessoa->cidade_id);
            $estado = null;

            if ($cidade != null) {
                $estado = $this->estado->find($cidade->estado_id);
            }

            $retorno .= '"pessoa": {
                "id": "' . $modelPessoa->id . '",
                "nome": "' . $modelPessoa->nome . '",
                    "sobrenome": "' . $modelPessoa->sobrenome . '",
                    "cpf": "' . $modelPessoa->cpf . '",
                    "rg": "' . $modelPessoa->rg . '",
                    "data_nasc": "' . $modelPessoa->data_nasc . '",
                    "tel_1": "' . $modelPessoa->tel_1 . '",
                    "tel_2": "' . $modelPessoa->tel_2 . '",
                    "rua": "' . $modelPessoa->rua . '",
                    "bairro": "' . $modelPessoa->bairro . '",
                    "numero": "' . $modelPessoa->numero . '",
                    "cep": "' . $modelPessoa->cep . '",
                    "complemento": "' . $modelPessoa->complemento . '"';
            if ($cidade == null) {
                $retorno .= ',
                        " cidade": "",
                        "estado": ""';
            } else {
                $retorno .= ',
                    "cidade": "' . $cidade->nome . '",
                    "estado": "' . $estado->sigla . '"';
            }
            $retorno .= '}';
        } else {
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


    public function GetEmpresas($id)
    {

        $empresa = DB::select(
            "SELECT empresas.id, empresas.razao_social, empresas.nome_fantasia, empresas.cnpj, empresas.inscricao_est,
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

        $compra = DB::select(
            "SELECT compras.id, data_venda, qtde_parcelas, valor_total, nome_fantasia, compra_paga
                               FROM compras, empresas
                               WHERE compras.empresa_id  = empresas.id
                               AND empresas.id = $idEmpresa
                               AND pessoa_id = $idUsuario
                               ORDER BY compra_paga = 'S', id;"
        );

        return  response()->json($compra);
    }

    public function GetParcelas($idCompra)
    {

        $parcela = DB::select(
            "SELECT id, nr_parcela, nr_boleto, valor_parcela, boleto_pago, data_vencimento
                                FROM public.parcelas
                                where compra_id = $idCompra
                                ORDER BY boleto_pago = 'S', nr_parcela;"
        );


        return  response()->json($parcela);
    }

    public function PagarParcela($idParcela, Request $request)
    {
        $parcela = Parcela::find($idParcela);
        $params = $request->all();
        $parcela->boleto_pago = $params['boleto_pago'];
        $parcela->save();

        $qtdeParcelasPagas = DB::select(    "SELECT COUNT(parcelas.id)
                                            FROM public.parcelas
                                            INNER JOIN public.compras on parcelas.compra_id = compras.id
                                            where parcelas.boleto_pago = 'S' and compras.id = $parcela->compra_id;"
                                        );
        $qtdeParcelasPagas = $qtdeParcelasPagas['0'];
        $qtdeParcelasPagas =  $qtdeParcelasPagas->count;

        $compra = Compra::find($parcela->compra_id);

        if ($compra->qtde_parcelas == $qtdeParcelasPagas) {
            $compra->compra_paga = 'S';
            $compra->save();

            $this->empresa = Empresa::find($compra->empresa_id);
            $this->pessoa = Pessoa::find($compra->pessoa_id);

            $this->desconto->pessoa_id = $compra->pessoa_id;
            $this->desconto->cpf = $this->pessoa->cpf;
            $this->desconto->compra_id = $compra->id;
            $this->desconto->valor_compra = $compra->valor_total;
            $this->desconto->valor_desconto = ($this->empresa->porcentagem_desc * 0.01) * $compra->valor_total;

            $this->desconto->save();
        }

        return response('Compra paga com sucesso ', 200);
    }

    public function GetCidade($id)
    {
        $cidade = Cidade::find($id);

        return  response()->json($cidade);
    }

    public function GetCidades($idEstado)
    {
        $cidade = DB::select(
            "SELECT id, nome, ibge_code, estado_id, created_at, updated_at
                                FROM public.cidades
                                WHERE estado_id = $idEstado;"
        );

        return  response()->json($cidade);
    }

    public function GetCidadeEstado($idPessoa)
    {


        $query = DB::select(
            "SELECT cidades.nome, estados.sigla
                                   FROM estados
                                   INNER JOIN cidades on estados.id = cidades.estado_id
                                   INNER JOIN pessoas on cidades.id = pessoas.cidade_id
                                   WHERE pessoas.id = $idPessoa;"
        );

        return  response()->json($query[0]);
    }

    public function AtualizarPessoa($idPessoa, Request $request)
    {
        $params = $request->all();

        $this->pessoa = Pessoa::find($idPessoa);

        switch ($params['campo']) {
            case 'nome':
                $this->pessoa->nome = $params['valorNovo'];
                break;
            case 'sobrenome':
                $this->pessoa->sobrenome = $params['valorNovo'];
                break;
            case 'tel_1':
                $this->pessoa->tel_1 = $params['valorNovo'];
                break;
            case 'tel_2':
                $this->pessoa->tel_2 = $params['valorNovo'];
                break;
        }

        $this->pessoa->save();

        return  response()->json($this->pessoa);
    }

    public function AtualizarEndereco($idPessoa, Request $request)
    {
        $params = $request->all();

        $this->pessoa = Pessoa::find($idPessoa);

        $this->pessoa->rua = $params['rua'];
        $this->pessoa->bairro = $params['bairro'];
        $this->pessoa->numero = $params['numero'];
        $this->pessoa->cep = $params['cep'];
        $this->pessoa->complemento = $params['complemento'];
        $this->pessoa->cidade_id = $params['cidade_id'];

        $this->pessoa->save();

        return  response()->json($this->pessoa);
    }

    public function GerarBoleto($idParcela)
    {
        $this->parcela = Parcela::find($idParcela);

        $nr_boleto = $this->gerarNumBoleto();

        $this->parcela->nr_boleto = $nr_boleto;

        $this->parcela->save();

        return  response()->json($this->parcela);
    }

    public function gerarNumBoleto()
    {
        $Caracteres = '0123456789';
        $QuantidadeCaracteres = strlen($Caracteres);
        $QuantidadeCaracteres--;
        $numBoleto = null;
        for ($x = 1; $x <= 30; $x++) {
            $Posicao = rand(0, $QuantidadeCaracteres);
            $numBoleto .= substr($Caracteres, $Posicao, 1);
        }

        return $numBoleto;
    }

    public function GetComprasPagas($idPessoa, $idEmpresa)
    {
        $query = DB::select("SELECT compras.id, compras.data_venda, compras.qtde_parcelas, compras.valor_total, compras.compra_paga, compras.empresa_id, compras.pessoa_id
                                FROM pessoas
                                INNER JOIN compras ON pessoas.id = compras.pessoa_id
                                INNER JOIN empresas ON compras.empresa_id = empresas.id
                                WHERE compras.compra_paga = 'S'
                                AND compras.pessoa_id = $idPessoa
                                AND compras.empresa_id = $idEmpresa;"
                            );

        return  response()->json($query);
    }

    //não sei se vai estar certo mais to fazendo um commit
}
