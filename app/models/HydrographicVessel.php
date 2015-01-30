<?php

class HydrographicVessel extends Model {
	
	public $table = 'hydrographic_reservoirs';

	public function status()
	{

		return $this->hasMany('HydrographicVesselStatus', 'hydrographic_vessel_id');
	}
}
