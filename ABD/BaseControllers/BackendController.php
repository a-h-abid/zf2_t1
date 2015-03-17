<?php namespace ABD\BaseControllers;

use Zend\View\Model\ViewModel;

abstract class BackendController extends MasterController {
	
	/**
	 * Get layer name
	 *
	 * @return string
	 */
	final protected function getLayerName()
	{
		return "Backend";
	}

	/**
	 * Get layout name
	 *
	 * @return string
	 */
	final protected function getLayerLayout()
	{
		return "admin/layout";
	}
	
}