<?php namespace Application\Controller;

use ABD\BaseControllers\BackendController;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends BackendController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function testAction()
    {
        $ViewModel = new ViewModel();

        return $ViewModel;
    }
}
