<?php

class ReservoirsTransformer {

	public function transform($vessel)
	{

		return [
			'id'					=> $vessel->id,
			'description' 		=> $vessel->description,
			'latest_status' 	=> [
				'percentage' => $vessel->latest_status->percentage,
				'created_at' => $vessel->latest_status->created_at->format('m/d/Y h:i:s')
			]
		];
	}
}
