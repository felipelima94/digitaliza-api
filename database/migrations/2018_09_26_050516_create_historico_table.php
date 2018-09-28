<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico', function (Blueprint $table){
            $table->integer('usuario_id')->unisgned();
            $table->integer('documento_id')->undigned();
            $table->string('operacao');
            $table->timestamps();

            // $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico');
        
    }
}
