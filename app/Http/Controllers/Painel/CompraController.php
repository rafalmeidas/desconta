<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Requests\Painel\CompraFormRequest;
use App\Http\Requests\Painel\XmlFormRequest;
use App\Http\Controllers\Controller;
use App\Models\Painel\Compra;
use App\Models\Painel\Desconto;
use App\Models\Painel\Pessoa;
use App\Models\Painel\Parcela;
use App\Http\Controllers\Painel\PessoaController;
use DB;

class CompraController extends Controller
{
    private $compra;
    private $pessoa;
    private $desconto;
    private $parcela;
    private $totalPage = 10;

    public function __construct(Compra $compra, Pessoa $pessoa, Desconto $desconto, Parcela $parcela)
    {
        $this->compra = $compra;
        $this->pessoa = $pessoa;
        $this->desconto = $desconto;
        $this->parcela = $parcela;
    }

    public function index()
    {
        $titulo = "Listagem de Compras";
        $compras = $this->compra->where('empresa_id', auth()->user()->empresa_id)->orderBy('data_venda')->paginate($this->totalPage);
        //dd($compras->data_venda);
        return view('painel.compra.index', compact('titulo', 'compras'));
    }


    public function create()
    {
        return view('painel.compra.xml');
    }

    public function createCompra()
    {
        return view('painel.compra.create-edit');
    }

    public function store(CompraFormRequest $request)
    {
        //Inicia  o database Transaction
        DB::beginTransaction();

        $dataForm = $request->all();

        //consulta o cliente que veio da nf
        $pessoa = $this->consultarPessoa($dataForm['cpf']);

        //Validação do cliente
        if ($dataForm['pessoa_id'] == $pessoa->id) {
            $dataForm['pessoa_id'] = $pessoa->id;
        } else {
            //Fail, desfaz as alterações no banco de dados
            DB::rollBack();
            return redirect()->back()->with('error', 'Código do cliente difere da NFe!');
        }

        //Validação da empresa logada
        $dataForm['empresa_id'] = (!isset($dataForm['empresa_id'])) ? auth()->user()->empresa_id : auth()->user()->empresa_id;


        //Validação da data atual da compra
        if ($dataForm['data_venda'] == date('Y-m-d')) {
            $insert = $this->compra->create($dataForm);
        } else {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data incorreta!');
        }

        //Inserindo dados do desconto
        if ($dataForm['qtde_parcelas'] == 1) {
            $valorDesconto = (float) (auth()->user()->empresa->porcentagem_desc * $dataForm['valor_total']) / 100;
            $dataDesc = array(
                'pessoa_id' => $dataForm['pessoa_id'],
                'cpf' => $dataForm['cpf'],
                'compra_id' => $insert->id,
                'valor_compra' => $dataForm['valor_total'],
                'valor_desconto' => $valorDesconto,
            );
            $insertDesc = $this->desconto->create($dataDesc);
        }

        if ($dataForm['qtde_parcelas'] > 1) {
            $Caracteres = '0123456789';
            $QuantidadeCaracteres = strlen($Caracteres);
            $QuantidadeCaracteres--;

            print_r($valorParcela = ($dataForm['valor_total'] / $dataForm['qtde_parcelas']));

            for ($i = 0; $i < $dataForm['qtde_parcelas']; $i++) {
                $numBoleto = null;
                
                for ($x = 1; $x <= 30; $x++) {
                    $Posicao = rand(0, $QuantidadeCaracteres);
                    $numBoleto .= substr($Caracteres, $Posicao, 1);
                }
                $dataParcela = array(
                    'nr_parcela' => $i+1,
                    'nr_boleto'  => $numBoleto,
                    'valor_parcela'  => $valorParcela,
                    'compra_id'  => $insert->id //Pega o id da ultima compra
                );
                $insertParcela = $this->parcela->create($dataParcela);
                if ($insertParcela) {
                    DB::commit();
                } else {
                    DB::rollBack();
                }
            }
        }

        //dd($dataDesc);
        if ($insert && isset($insertDesc)) {
            DB::commit();
            return redirect()->route('compra.index')->with('success', 'Compra efetuada com sucesso!');
        } elseif ($insert) {
            DB::commit();
            return redirect()->route('compra.index')->with('success', 'Compra efetuada com sucesso!');
        } else {
            DB::rollBack();
            return redirect()->route('compra.create-compra')->with('error', 'Não foi possível efetuar a compra');
            ;
        }
    }

    public function show($id)
    {
        $compra = $this->compra->find($id);

        $titulo = "Compra";

        return view('painel.compra.show', compact('titulo', 'compra'));
    }


    public function edit($id)
    {
        $compra = $this->compra->find($id);

        $data = date('Y-m-d');
        $titulo = "Editar Compra: {$compra->pessoa->nome}";

        return view('painel.compra.create-edit', compact('titulo', 'compra', 'data'));
    }


    public function update(CompraFormRequest $request, $id)
    {
        $dataForm = $request->all();

        $compra = $this->compra->find($id);

        $update = $compra->update($dataForm);

        if ($update) {
            return redirect()->route('compra.index')->with('success', 'Compra atualizada com sucesso!');
        } else {
            return redirect()->route('compra.edit', $id)->with(['errors' => 'Falha ao editar']);
        }
    }

    public function destroy($id)
    {
        $pessoa = $this->pessoa->find($id);

        $delete = $pessoa->delete();
        if ($delete) {
            return redirect()->route('pessoa.index');
        } else {
            return redirect()->route('pessoa.show', $id)->with(['errors' => 'Falha ao deletar']);
        }
    }

    public function xml(XmlFormRequest $request, Pessoa $pessoa)
    {
        $dataForm =  $request->only('xml');
        //dd($dataForm);
        $xml = file_get_contents($dataForm['xml']);
        $xml = simplexml_load_string($xml);

        $nf = $xml->NFe->infNFe->dest;
        $cpf = (string) $xml->NFe->infNFe->dest->CPF;
        //dd($cpf);
        $cpf = $this->consultarPessoa($cpf);
        $pessoa = (object) $cpf;
        //dd($cpf);
        if (isset($cpf) != null) {
            $titulo = 'Cadastro de Compra';
            return view('painel.compra.create-edit', compact('titulo', 'pessoa'));
        } else {
            //salvar o cliente da nf no banco
            $nf = json_encode($nf);
            $nf = json_decode($nf);

            //Separando nome e sobrenome no array
            $nome = explode(" ", $nf->xNome);

            $dados = array(
                'nome' => $nome[0],
                'sobrenome' => $nome[1],
                'tipo_pessoa' => 'Física',
                'cpf' => $nf->CPF,
                'cnpj' => null,
                'rg' => null,
                'data_nasc' => null,
                'tel_1' => null,
                'tel_2' => null,
                'rua' => $nf->enderDest->xLgr,
                'bairro' => $nf->enderDest->xBairro,
                'numero' => $nf->enderDest->nro,
                'cep' => $nf->enderDest->CEP,
                'complemento' => $nf->enderDest->xCpl,
                'cidade_id' => null,
                'status' => true
            );

            $insert = PessoaController::storePessoa($dados);
            if ($insert) {
                //consulta o ultimo cpf inserido no banco
                $cpf = $this->consultarPessoa($insert->cpf);
                $pessoa = (object) $cpf;
                $titulo = 'Cadastro de Compra';
                return view('painel.compra.create-edit', compact('titulo', 'pessoa'))->with(['success' => 'Cliente cadastrado com sucesso']);
                ;
            } else {
                return redirect()->back()->with(['errors' => 'Falha ao cadastrar o cliente']);
            }
        }
    }

    public function consultarPessoa($cpf)
    {
        $pessoa = Pessoa::where('cpf', $cpf)
            ->orderBy('nome')
            ->get();

        //Retorna um JSON com os dados da pessoa consultada
        foreach ($pessoa as $valor) {
            $dados = $valor;
            $dados = json_encode($dados);
        }
        //Faz o parsing de JSON para um objeto simples
        if (isset($dados)) {
            return json_decode($dados);
        }
    }

    public function criarParcelas($dataForm)
    {
    }
}
