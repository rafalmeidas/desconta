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
            $table->double('valor_compra', 8, 2);
            $table->double('valor_desconto', 8, 2);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('descontos');
    }
}
