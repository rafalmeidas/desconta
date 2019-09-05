<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Painel\CidadeFormRequest;
use App\Models\Painel\Cidade;
use App\Models\Painel\Estado;

class CidadeController extends Controller {

    private $cidade;
    private $totalPage = 10;
    
    public function __construct(Cidade $cidade) {
        $this->cidade = $cidade;
    }
    
    public function index() {
        $titulo = "Listagem de Cidades";
        $cidades = $this->cidade->orderBy('nome')->paginate($this->totalPage);
        
        return view('painel.cidade.index', compact('titulo', 'cidades'));
    }

    public function create() {
        $titulo = 'Cadastro de Cidade';
        $estados = Estado::pluck('nome', 'id')->all();
        //dd($estados);
        return view('painel.cidade.create-edit', compact('titulo', 'estados'));
    }

    public function store(CidadeFormRequest $request) {
        $dataForm = $request->all();

        $dataForm['status'] = (!isset($dataForm['status'])) ? 0 : 1;

        $insert = $this->cidade->create($dataForm);
        
        if ($insert) {
            return redirect()->route('cidade.index');
        } else {
            return redirect()->back();
        }
    }

    public function show($id) {
        $cidade = $this->cidade->find($id);

        $titulo = "Cidade";

        return view('painel.cidade.show', compact('titulo', 'cidade'));
    }

    public function edit($id) {
        $cidade = $this->cidade->find($id);
        $estados = Estado::pluck('nome', 'id')->all();
        $titulo = "Editar Cidade: {$cidade->nome}";

        return view('painel.cidade.create-edit', compact('titulo', 'cidade', 'estados'));
    }

    public function update(CidadeFormRequest $request, $id) {
        $dataForm = $request->all();

        $cidade = $this->cidade->find($id);
        
        $dataForm['status'] = (!isset($dataForm['status'])) ? 0 : 1;

        $update = $cidade->update($dataForm);

        if ($update) {
            return redirect()->route('cidade.index');
        } else {
            return redirect()->route('cidade.edit', $id)->with(['errors' => 'Falha ao editar']);
        }
    }

    public function destroy($id) {
        $cidade = $this->cidade->find($id);

        $delete = $cidade->delete();
        if ($delete) {
            return redirect()->route('cidade.index');
        } else {
            return redirect()->route('cidade.show', $id)->with(['errors' => 'Falha ao deletar']);
        }
    }   
}