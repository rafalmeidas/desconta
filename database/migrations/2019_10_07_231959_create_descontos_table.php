<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescontosTable extends Migration
{

    public function up()
    {
        Schema::create('descontos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pessoa_id');
            $table->string('cpf', 45);
            $table->integer('compra_id');
            $table->float('valor_compra');
            $table->float('valor_desconto');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('descontos');
    }
}
