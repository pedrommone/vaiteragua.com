<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class WatershedStatus extends Eloquent {

	use SoftDeletingTrait;
	
	public $table = 'watershed_statuses';
}
