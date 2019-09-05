<?php

use Illuminate\Database\Seeder;
use App\Models\Painel\Empresa;

class EmpresasTableSeeder extends Seeder {

    public function run() {
        Empresa::create([
            'razao_social' => 'RAZÃO SOCIAL',
            'nome_fantasia' => 'NOME FANTASIA',
            'cnpj' => '00.000.000/0000-00',
            'inscricao_est' => '000.00000-00',
            'tel' => '(00)0 0000-0000',
            'rua' => 'RUA',
            'bairro' => 'BAIRRO',
            'numero' => '0000',
            'cep' => '00.000-000',
            'complemento' => 'Prox...',
            'cidade_id' => '1',
            'status' => true
        ]);
        
        Empresa::create([
            'razao_social' => 'Sistema DES-CONTA',
            'nome_fantasia' => 'DES-CONTA',
            'cnpj' => '74.382.655/0001-08',
            'inscricao_est' => '108.18256-33',
            'tel' => '(44)9 9856-0723',
            'rua' => 'São Rafael',
            'bairro' => 'Parque San Marino',
            'numero' => '4574',
            'cep' => '87.509-030',
            'complemento' => 'Prox...',
            'cidade_id' => '1',
            'status' => true
        ]);
    }

}
