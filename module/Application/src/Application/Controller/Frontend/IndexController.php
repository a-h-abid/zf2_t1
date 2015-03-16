<?php namespace Application\Controller\Frontend;

use ABD\BaseControllers\FrontendController;

class IndexController extends FrontendController
{
    public function indexAction()
    {
        return $this->render();
    }
}
