<?php

use Illuminate\Database\Seeder;
use App\Models\Painel\Cidade;

class CidadesTableSeeder extends Seeder {

    public function run() {
        Cidade::create([
            'nome' => 'Umuarama',
            'estado_id' => 1,
            'status' => true
        ]);
    }

}
