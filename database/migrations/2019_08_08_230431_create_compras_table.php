<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('data_venda');
            $table->integer('qtde_parcelas');
            $table->double('valor_total', 8, 2);
            $table->string('compra_paga', 1);
            $table->integer('empresa_id')->unsigned()->default(0);
            $table->integer('pessoa_id')->unsigned()->default(0);
            $table->timestamps();
            $table->foreign('empresa_id')
                    ->references('id')
                    ->on('empresas')
                    ->onDelete('cascade');
            $table->foreign('pessoa_id')
                    ->references('id')
                    ->on('pessoas')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compras');
    }
}
