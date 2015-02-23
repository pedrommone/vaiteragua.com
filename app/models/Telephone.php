<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Telephone extends Eloquent {

	use SoftDeletingTrait;
	
	public $table = 'telephones';

	protected $fillable = ['number'];
}
