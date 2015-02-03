<?php

class ReservoirsTransformer {

	public function transform($reservoirs)
	{

		$reser = [];

		die( var_dump($reservoirs) );

		foreach ($reservoirs as $aux)
			$reser[] = [
				'description' 	=> $aux->description,
				'last_updated' => $aux->last_updated,
			];


		return var_dump($reser);
	}
}
