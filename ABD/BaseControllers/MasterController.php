<?php namespace ABD\BaseControllers;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;

abstract class MasterController extends AbstractActionController {
	
	/**
	 * Doctrine's Entity Manager
	 *
	 * @var Doctrine\ORM\EntityManager
	 */
	private $entityManager;

	/**
	 * Request names stored in array
	 *
	 * @var array
	 */
    private $requestNames;

    /**
     * Get the Layer Name
     *
     * @return string
     */
    abstract protected function getLayerName();

    /**
     * Get the Layer's Layout
     *
     * @return string
     */
    abstract protected function getLayerLayout();

    /**
     * onDispatch description
     *
     * @param  MvcEvent $e
     * @return void
     */
    public function onDispatch(MvcEvent $e)
    {
        $this->setRequestNames($e);

        return parent::onDispatch($e);
    }

    /**
     * Get the Requested Entity
     *
     * @param  string $entity
     * @return Entity
     */
    protected function entity($entity)
    {
        return $this->getEntityManager()->getRepository($entity);
    }

    /**
     * Get Doctrine Entity Manager
     *
     * @return Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        if (null === $this->entityManager)
        {
            $this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->entityManager;
    }

    /**
     * Get the Request Names
     *
     * @return array
     */
    protected function getRequestNames()
    {
    	if (!$this->requestNames) {
    		$this->setRequestNames();
    	}

    	return $this->requestNames;
    }

    /**
     * Set Page Status to Not Found
     *
     * @return void
     */
    protected function pageNotFound()
    {
        $this->getResponse()->setStatusCode(404);
        return;
    }

    /**
     * Render view file, dependent on view layer
     *
     * @param  array $variables
     * @param  array $options
     * @return ViewModel
     */
    protected function render($variables = null, $options = null)
    {
    	$viewPath = strtolower(
    		$this->requestNames['module'].'/'.
    		$this->requestNames['layer'].'/'.
    		$this->requestNames['controller'].'/'.
    		$this->requestNames['action']
    	);

    	$viewModel = new ViewModel($variables, $options);
    	$viewModel->setTemplate($viewPath)
                    ->setVariables([
                        'requestNames' => $this->requestNames,
                    ]);

        // Set the layout file to use
        $this->layout($this->getLayerLayout());

    	return $viewModel;
    }

    /**
     * Set Request Names of Module, Controllers etc.
     *
     * @param MvcEvent $e
     */
    private function setRequestNames(MvcEvent $e)
    {
        if (is_array($this->requestNames)) {
            return;
        }

        $sm = $e->getApplication()->getServiceManager();

        $router = $sm->get('router');
        $request = $sm->get('request');
        $matchedRoute = $router->match($request);

        $params = $matchedRoute->getParams();

        $full_controller = $params['controller'];
        $module_array = explode('\\', $full_controller);

        $this->requestNames['module'] = array_shift($module_array);
        $this->requestNames['full_controller'] = $full_controller;
        $this->requestNames['layer'] = $this->getLayerName();
        $this->requestNames['controller'] = array_pop($module_array);
        $this->requestNames['action'] = $params['action'];
        $this->requestNames['route'] = $matchedRoute->getMatchedRouteName();
    }

}