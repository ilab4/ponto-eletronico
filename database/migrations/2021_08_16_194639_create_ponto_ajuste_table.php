<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePontoAjusteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ponto_ajuste', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('ponto_ajuste_id')->nullable();
			$table->integer('ponto_id')->nullable();
			$table->integer('usuario_id')->nullable();
			$table->string('tipo', 45)->nullable();
			$table->date('data')->nullable();
			$table->time('hora')->nullable();
			$table->integer('ponto_razao_id')->nullable();
			$table->string('obs_funcionario', 200)->nullable();
			$table->string('obs_supervisor', 200)->nullable();
			$table->string('anexo', 100)->nullable();
			$table->smallInteger('status')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ponto_ajuste');
	}

}
