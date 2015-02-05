<?php

class CurrentWatershedTransformer {

	public function transform($watershed)
	{

		return [
			'percentage' 	=> $watershed->percentage,
			'last_update'	=> $watershed->created_at->format('m/d/Y h:i:s')
		];
	}
}
