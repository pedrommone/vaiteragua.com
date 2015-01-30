<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialSchema extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('hydrographic_reservoirs', function($table)
		{

			$table->increments('id');
			$table->string('description');

			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('hydrographic_vessel_statuses', function($table)
		{

			$table->increments('id');
			$table->unsignedInteger('hydrographic_vessel_id');
			$table->tinyInteger('percentage');

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('hydrographic_vessel_id')
				->on('hydrographic_reservoirs')
				->references('id');
		});

		Schema::create('watershed_statuses', function($table)
		{

			$table->increments('id');
			$table->tinyInteger('percentage');

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::drop('watershed_statuses');
		Schema::drop('hydrographic_vessel_statuses');
		Schema::drop('hydrographic_reservoirs');
	}

}
