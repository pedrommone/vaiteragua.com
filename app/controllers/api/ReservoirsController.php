<?php

namespace Api;

use \Dingo\Api\Routing\ControllerTrait;
use \VesselHistoryTransformer;
use \GoogleChartTransformer;
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

	/*
	 * Return an array made for google charts
	 */
	public function getGoogleChart()
	{

		$status = HydrographicVessel::with(['status' => function($query) {

			$query->orderBy('created_at', 'desc')
				->take(30);
		}])
			->get();

		// Transform is being ignored,
		// I'll write the transform code here for now
		// return $this->response->item(['t'], new GoogleChartTransformer);
		
		$data = [
			'columns' => ['Data']
		];

		// Index dates
		foreach ($status as $row)
			$data['columns'][] = $row->description;

		// Populate data
		foreach ($status as $row)
		{

			foreach ($row->status as $point)
			{

			
				$aux_index = $point->created_at->format('d/m/y');
				$aux_colun = array_search($row->description, $data['columns']);

				if ( ! isset($data[$aux_index][0]) )
				{

					$data[$aux_index][0] = $point->created_at->format('d/m/y');
				}

				$data[$aux_index][$aux_colun] = (double) $point->percentage;
			}
		}

		// Clean indexes
		foreach ($data as $k => $v)
		{

			$data[$k] = array_values($v);
		}

		return array_values($data);
	}

}
