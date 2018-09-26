<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table)  {
            $table->increments('id');
            $table->integer('empresa_id')->unsigned();
            $table->integer('usuario_id')->unsigned(); // author
            $table->string('nome_arquivo');
            $table->integer('local_armazenado');
            $table->string('tamanho')->nullable()->default('--');
            $table->string('type')->nullable()->default('unknown');
            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('local_armazenado')->references('id')->on('pastas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
