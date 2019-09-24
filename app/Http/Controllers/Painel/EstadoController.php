<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Painel\Estado;
use App\Http\Requests\Painel\EstadoFormRequest;

class EstadoController extends Controller {

    private $estado;
    private $totalPage =5;
    
    public function __construct(Estado $estado) {
        $this->estado = $estado;
    }

    public function index() {
        $titulo = "Listagem de Estados";
        $estados = $this->estado->orderBy('nome')->paginate($this->totalPage);
        return view('painel.estado.index', compact('titulo', 'estados'));
    }

    public function create() {
        $titulo = 'Cadastro de Estado';
        return view('painel.estado.create-edit', compact('titulo'));
    }

    public function store(EstadoFormRequest $request) {
        $dataForm = $request->all();

        $dataForm['status'] = (!isset($dataForm['status'])) ? 0 : 1;

        $insert = $this->estado->create($dataForm);
        
        if ($insert) {
            return redirect()->route('estado.index');
        } else {
            return redirect()->back();
        }
    }

    public function show($id) {
        $estado = $this->estado->find($id);
        $titulo = "Estado";

        return view('painel.estado.show', compact('titulo', 'estado'));
    }

    public function edit($id) {
        $estado = $this->estado->find($id);
        $titulo = "Editar Estado: {$estado->nome}";

        return view('painel.estado.create-edit', compact('titulo', 'estado'));
    }

    public function update(EstadoFormRequest $request, $id) {
        $dataForm = $request->all();

        $estado = $this->estado->find($id);
        
        $dataForm['status'] = (!isset($dataForm['status'])) ? 0 : 1;

        $update = $estado->update($dataForm);

        if ($update) {
            return redirect()->route('estado.index');
        } else {
            return redirect()->route('estado.edit', $id)->with(['errors' => 'Falha ao editar']);
        }
    }

    public function destroy($id) {
        $estado = $this->estado->find($id);

        $delete = $estado->delete();
        if ($delete) {
            return redirect()->route('estado.index');
        } else {
            return redirect()->route('estado.show', $id)->with(['errors' => 'Falha ao deletar']);
        }
    }

}
