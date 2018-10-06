<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalizacaoPalavraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localizacao_palavra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_doc');
            $table->integer('id_empresa');
            $table->integer('id_palavra');
            $table->integer('posicao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localizacao_palavra');
    }
}
