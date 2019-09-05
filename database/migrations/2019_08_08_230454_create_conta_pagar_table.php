<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContaPagarTable extends Migration {

    public function up() {
        Schema::create('conta_pagar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('conta_pagar');
    }

}
