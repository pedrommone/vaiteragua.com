<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixReplaceTinyintegerForDouble extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	
		DB::statement("ALTER TABLE watershed_statuses MODIFY COLUMN percentage DOUBLE(8,2)");
		DB::statement("ALTER TABLE hydrographic_vessel_statuses MODIFY COLUMN percentage DOUBLE(8,2)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		DB::statement("ALTER TABLE watershed_statuses MODIFY COLUMN percentage TINYINT(4)");
		DB::statement("ALTER TABLE hydrographic_vessel_statuses MODIFY COLUMN percentage TINYINT(4)");
	}

}
