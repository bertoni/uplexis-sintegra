<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSintegraTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sintegra', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id');

			$table->integer('idusuario')->unsigned();
    		$table->foreign('idusuario')
		        ->references('id')
		        ->on('usuario')
		        ->onDelete('cascade');

			$table->string('cnpj');
			$table->string('resultado_json');
			$table->timestamps();

			$table->index('cnpj');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sintegra');
	}

}
