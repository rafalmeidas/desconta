<?php

use Illuminate\Database\Seeder;
use App\Models\Painel\Compra;

class ComprasTableSeeder extends Seeder
{

    public function run()
    {
        Compra::create([
            'data_venda' => '2019-10-16',
            'qtde_parcelas' => 2,
            'valor_total' => 20,
            'empresa_id' => 1,
            'pessoa_id' => 2
        ]);
    }
}
