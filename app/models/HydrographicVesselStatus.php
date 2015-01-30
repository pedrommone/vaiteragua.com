<?php

class HydrographicVesselStatus extends Eloquent {
	
	public $table = 'hydrographic_vessel_statuses';

	public function hydrographicVessel()
	{

		return $this->belongsTo('HydrographicVessel', 'hydrographic_vessel_id');
	}
}
