<?php

class WatershedTransformer {

	public function transform($history)
	{

		return [
			'percentage' 	=> $history->percentage,
			'created_at'	=> $history->created_at->format('m/d/Y h:i:s')
		];
	}
}
