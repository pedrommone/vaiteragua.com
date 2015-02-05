<?php

namespace Api;

use \Dingo\Api\Routing\ControllerTrait;
use \VesselHistoryTransformer;
use \ReservoirsTransformer;
use \HydrographicVessel;

class ReservoirsController extends \Controller {

	use ControllerTrait;

	/*
	 * List all reservoirs
	 */
	public function getIndex()
	{

		$reservoirs = HydrographicVessel::all();

		return $this->response->collection($reservoirs, new ReservoirsTransformer);
	}

	/*
	 * Get vessel last 30 days history
	 */
	public function getId($id)
	{

		$history = HydrographicVessel::with(['status' => function($query) {

			$query->orderBy('created_at', 'desc')
				->take(30);
		}])
			->findOrFail($id)
			->status;

		return $this->response->collection($history, new VesselHistoryTransformer);
	}
}
