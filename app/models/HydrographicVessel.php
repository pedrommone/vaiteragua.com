<?php

class HydrographicVessel extends Eloquent {
	
	public $table = 'hydrographic_reservoirs';

	protected $fillable = ['description'];
	protected $appends = ['latest_status'];

	public function status()
	{

		return $this->hasMany('HydrographicVesselStatus', 'hydrographic_vessel_id');
	}

	public function getLatestStatusAttribute()
	{

		return $this
			->status()
			->orderBy('created_at', 'desc')
			->first();
	}
}
