<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTelephoneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('telephones', function($table)
		{

			$table->increments('id');
			$table->unsignedBigInteger('number');
			$table->timestamp('verified_at')->nullable();
			$table->enum('is_whatsapp', ['Y', 'N']);

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
		
		Schema::drop('telephones');
	}

}
