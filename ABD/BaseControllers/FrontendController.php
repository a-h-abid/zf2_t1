<?php namespace ABD\BaseControllers;

use Zend\View\Model\ViewModel;

abstract class FrontendController extends MasterController {
	
	/**
	 * Layer Name
	 *
	 * @var string
	 */
	private $layerName = 'Frontend';

	/**
	 * Layer Layout
	 *
	 * @var string
	 */
	private $layerLayout = 'layout/layout';

	/**
	 * Get layer name
	 *
	 * @return string
	 */
	final protected function getLayerName()
	{
		return $this->layerName;
	}
	
	/**
	 * Get layout name
	 *
	 * @return string
	 */
	final protected function getLayerLayout()
	{
		return $this->layerLayout;
	}
	
}