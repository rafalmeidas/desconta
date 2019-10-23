<?php

use Illuminate\Database\Seeder;
use App\Models\Painel\Empresa;

class EmpresasTableSeeder extends Seeder {

    public function run() {

        DB::table('empresas')->delete();

        DB::table('empresas')->insert([
            [ 'razao_social' => 'RAZÃO SOCIAL', 'nome_fantasia' => 'NOME FANTASIA', 'cnpj' => '00.000.000/0000-00', 'inscricao_est' => '000.00000-00', 'porcentagem_desc' => 5, 'tel' => '(00)0 0000-0000', 'rua' => 'RUA', 'bairro' => 'BAIRRO', 'numero' => '0000', 'cep' => '00.000-000', 'complemento' => 'Prox...', 'cidade_id' => '3172', 'status' => true],
            [ 'razao_social' => 'Sistema DES-CONTA', 'nome_fantasia' => 'DES-CONTA', 'cnpj' => '74.382.655/0001-08', 'inscricao_est' => '108.18256-33', 'porcentagem_desc' => 10, 'tel' => '(44)9 9856-0723', 'rua' => 'São Rafael','bairro' => 'Parque San Marino', 'numero' => '4574', 'cep' => '87.509-030', 'complemento' => 'Prox...', 'cidade_id' => '3172', 'status' => true],
            [ 'razao_social' => 'Casas Bahia LTDA', 'nome_fantasia' => 'Casas Bahia', 'cnpj' => '00.000.000/0000-00', 'inscricao_est' => '000.00000-00', 'porcentagem_desc' => 15, 'tel' => '(00)0 0000-0000', 'rua' => 'Av. Paraná', 'bairro' => 'Centro', 'numero' => '7524', 'cep' => '00.000-000', 'complemento' => 'Prox...', 'cidade_id' => '3172', 'status' => true],
            [ 'razao_social' => 'Lojas Mil Eirelli', 'nome_fantasia' => 'Lojas Mil - CALÇADOS', 'cnpj' => '00.000.000/0000-00', 'inscricao_est' => '000.00000-00', 'porcentagem_desc' => 7, 'tel' => '(00)0 0000-0000', 'rua' => 'Av. Paraná', 'bairro' => 'Centro', 'numero' => '6231', 'cep' => '00.000-000', 'complemento' => 'Prox...', 'cidade_id' => '3172', 'status' => true],
        ]);
    }

}
