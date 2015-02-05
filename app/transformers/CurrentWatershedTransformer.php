<?php

class CurrentWatershedTransformer {

	public function transform($watershed)
	{

		return [
			'percentage' 	=> number_format($watershed->percentage, 1, ',', '.'),
			'last_update'	=> $watershed->created_at->format('m/d/Y h:i:s')
		];
	}
}
