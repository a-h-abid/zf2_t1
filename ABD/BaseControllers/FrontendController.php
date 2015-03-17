<?php namespace ABD\BaseControllers;

use Zend\View\Model\ViewModel;

abstract class FrontendController extends MasterController {
	
	/**
	 * Get layer name
	 *
	 * @return string
	 */
	final protected function getLayerName()
	{
		return "Frontend";
	}
	
	/**
	 * Get layout name
	 *
	 * @return string
	 */
	final protected function getLayerLayout()
	{
		return "layout/layout";
	}
	
}