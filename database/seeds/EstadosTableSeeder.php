<?php

use Illuminate\Database\Seeder;
use App\Models\Painel\Estado;

class EstadosTableSeeder extends Seeder {

    public function run() {
        Estado::create([
            'nome' => 'Paraná', 
            'sigla' => 'PR', 
            'status' => true
        ]);
    }
}
