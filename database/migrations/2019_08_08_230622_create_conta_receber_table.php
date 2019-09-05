<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContaReceberTable extends Migration {

    public function up() {
        Schema::create('conta_receber', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('conta_receber');
    }

}
