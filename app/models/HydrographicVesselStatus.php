<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class HydrographicVesselStatus extends Eloquent {

	use SoftDeletingTrait;
	
	public $table = 'hydrographic_vessel_statuses';

	protected $fillable = ['percentage'];

	public function hydrographicVessel()
	{

		return $this->belongsTo('HydrographicVessel', 'hydrographic_vessel_id');
	}
}
