<?php

class HydrographicVessel extends Eloquent {
	
	public $table = 'hydrographic_reservoirs';

	protected $fillable = ['description'];

	public function status()
	{

		return $this->hasMany('HydrographicVesselStatus', 'hydrographic_vessel_id');
	}
}
