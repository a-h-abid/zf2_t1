<?php namespace ABD\BaseControllers;

use Zend\View\Model\ViewModel;

abstract class BackendController extends MasterController {
	
	/**
	 * Layer Name
	 *
	 * @var string
	 */
	private $layerName = 'Backend';

	/**
	 * Layer Layout
	 *
	 * @var string
	 */
	private $layerLayout = 'admin/layout';

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