<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePastasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pastas', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nome', 100)->default('Home');
			$table->integer('raiz')->unsigned()->nullable();
			$table->integer('usuario_id')->unsigned();
			$table->integer('empresa_id')->unsigned();
			$table->timestamps();

			$table->foreign('raiz')->references('id')->on('pastas')->onDelete('cascade');
			$table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('pastas');
	}
}
