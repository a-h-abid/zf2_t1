<?php namespace Administrator\Controller\Backend;

use ABD\BaseControllers\BackendController;

class IndexController extends BackendController {

    /**
     * Login Page
     *
     * @return ViewModel
     */
	public function loginAction()
	{
        return $this->render();
	}

	/**
     * Dashboard Page
     *
     * @return ViewModel
     */
	public function dashboardAction()
	{
        return $this->render();
	}

}