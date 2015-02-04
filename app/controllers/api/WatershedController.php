<?php

namespace Api;

use \Dingo\Api\Routing\ControllerTrait;
use \CurrentWatershedTransformer;
use \WatershedTransformer;
use \WatershedStatus;

class WatershedController extends \Controller {

	use ControllerTrait;

	/*
	 * List status from past 30 days
	 */
	public function getIndex()
	{

		$watershed_status = WatershedStatus::
			  orderBy('created_at', 'desc')
			->take(30)
			->get();

		return $this->response->collection($watershed_status, new WatershedTransformer);
	}

	/*
	 * List current status
	 */
	public function getCurrent()
	{

		$watershed_status = WatershedStatus::
			  orderBy('created_at', 'desc')
			->first();

		return $this->response->item($watershed_status, new CurrentWatershedTransformer);
	}
}
