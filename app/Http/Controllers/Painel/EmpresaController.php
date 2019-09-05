<?php

namespace App\Http\Controllers\Painel;


use App\Http\Controllers\Controller;
use App\Models\Painel\Empresa;
use App\Models\Painel\Cidade;
use App\Http\Requests\Painel\EmpresaFormRequest;

class EmpresaController extends Controller {

    private $empresa;
    private $totalPage = 10;

    public function __construct(Empresa $empresa) {
        $this->empresa = $empresa;
    }
    
    public function index() {
        $titulo = "Listagem de Empresas";  
        $empresas = $this->empresa->orderBy('razao_social')->paginate($this->totalPage);
        //dd($empresas);
        return view('painel.empresa.index', compact('titulo', 'empresas'));
    }

    public function create() {
        $titulo = 'Cadastro de Empresa';
        $cidades = Cidade::pluck('nome', 'id')->all();
        return view('painel.empresa.create-edit', compact('titulo', 'cidades'));
    }

    public function store(EmpresaFormRequest $request) {
        $dataForm = $request->all();

        $dataForm['status'] = (!isset($dataForm['status'])) ? 0 : 1;

        $insert = $this->empresa->create($dataForm);

        if ($insert) {
            return redirect()->route('empresa.index');
        } else {
            return redirect()->back();
        }
    }

    public function show($id) {
        $empresa = $this->empresa->find($id);

        $titulo = "Empresa";

        return view('painel.empresa.show', compact('titulo', 'empresa'));
    }

    public function edit($id) {
        $empresa = $this->empresa->find($id);
        $cidades = Cidade::pluck('nome', 'id')->all();
        $titulo = "Editar Empresa: {$empresa->nome}";
        
        //Não deixa o usuário acessar pela url uma empresa que não seja a sua
        //$this->authorize('updateEmpresa',$empresa);
        

        return view('painel.empresa.create-edit', compact('titulo', 'empresa', 'cidades'));
    }

    public function update(EmpresaFormRequest $request, $id) {
        $dataForm = $request->all();

        $empresa = $this->empresa->find($id);

        $dataForm['status'] = (!isset($dataForm['status'])) ? 0 : 1;

        $update = $empresa->update($dataForm);

        if ($update) {
            return redirect()->route('empresa.index');
        } else {
            return redirect()->route('empresa.edit', $id)->with(['errors' => 'Falha ao editar']);
        }
    }

    public function destroy($id) {
        $empresa = $this->empresa->find($id);

        $delete = $empresa->delete();
        if ($delete) {
            return redirect()->route('empresa.index');
        } else {
            return redirect()->route('empresa.show', $id)->with(['errors' => 'Falha ao deletar']);
        }
    }

}
