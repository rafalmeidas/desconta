<?php

use Illuminate\Database\Seeder;
use App\Models\Painel\Pessoa;

class PessoasTableSeeder extends Seeder
{
    public function run()
    {
        Pessoa::create([
            'nome' => 'teste',
            'sobrenome' => '1',
            'tipo_pessoa' => 'Física',
            'cpf' => '000000000000000',
            'cnpj' => '00000000000000',
            'rg' => '0000000000',
            'data_nasc' => '2018-08-03',
            'tel_1' => '1234',
            'tel_2' => '1234',
            'rua' => 'rua',
            'bairro' => 'BAIRRO',
            'numero' => '0000',
            'cep' => '00.000-000',
            'complemento' => 'Prox...',
            'cidade_id' => '1',
            'status' => true
        ]);

        Pessoa::create([
            'nome' => 'Rafael',
            'sobrenome' => 'Almeida',
            'tipo_pessoa' => 'Física',
            'cpf' => '12121232323',
            'cnpj' => '12323242342',
            'rg' => '3565436436',
            'data_nasc' => '2018-08-03',
            'tel_1' => '1234332',
            'tel_2' => '1234313',
            'rua' => 'rua',
            'bairro' => 'BAIRRO',
            'numero' => '0000',
            'cep' => '00.000-000',
            'complemento' => 'Prox...',
            'cidade_id' => '1',
            'status' => true
        ]);

        Pessoa::create([
            'nome' => 'Leandro',
            'sobrenome' => 'William',
            'tipo_pessoa' => 'Física',
            'cpf' => '12187686573',
            'cnpj' => '456546743544234',
            'rg' => '986456373',
            'data_nasc' => '2018-08-03',
            'tel_1' => '1234332',
            'tel_2' => '1234313',
            'rua' => 'rua',
            'bairro' => 'BAIRRO',
            'numero' => '0000',
            'cep' => '00.000-000',
            'complemento' => 'Prox...',
            'cidade_id' => '1',
            'status' => true
        ]);

        Pessoa::create([
            'nome' => 'João',
            'sobrenome' => 'Fonseca',
            'tipo_pessoa' => 'Física',
            'cpf' => '12314213341231234',
            'cnpj' => '65865476245523',
            'rg' => '643775215341',
            'data_nasc' => '2018-08-03',
            'tel_1' => '1234332',
            'tel_2' => '1234313',
            'rua' => 'rua',
            'bairro' => 'BAIRRO',
            'numero' => '0000',
            'cep' => '00.000-000',
            'complemento' => 'Prox...',
            'cidade_id' => '1',
            'status' => true
        ]);

        Pessoa::create([
            'nome' => 'teste',
            'sobrenome' => '2',
            'tipo_pessoa' => 'Física',
            'cpf' => '000000000000000',
            'cnpj' => '00000000000000',
            'rg' => '0000000000',
            'data_nasc' => '2018-03-03',
            'tel_1' => '12345',
            'tel_2' => '12345',
            'rua' => 'rua 1',
            'bairro' => 'BAIRRO 1',
            'numero' => '0000',
            'cep' => '00.000-000',
            'complemento' => 'Prox...',
            'cidade_id' => '1',
            'status' => true
        ]);

        Pessoa::create([
            'nome' => 'teste',
            'sobrenome' => '3',
            'tipo_pessoa' => 'Física',
            'cpf' => '000000000000000',
            'cnpj' => '00000000000000',
            'rg' => '0000000000',
            'data_nasc' => '2018-03-03',
            'tel_1' => '12345',
            'tel_2' => '12345',
            'rua' => 'rua 3',
            'bairro' => 'BAIRRO 3',
            'numero' => '0000',
            'cep' => '00.000-000',
            'complemento' => 'Prox...',
            'cidade_id' => '1',
            'status' => true
        ]);
    }
}
