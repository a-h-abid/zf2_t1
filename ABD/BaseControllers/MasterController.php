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
	protected $entityManager;

	/**
	 * Layer Name
	 *
	 * @var string
	 */
	protected $layerName;

	/**
	 * Request names stored in array
	 *
	 * @var array
	 */
    protected $requestNames;

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

    	return $viewModel;
    }

    /**
     * Set Request Names of Module, Controllers etc.
     *
     * @param MvcEvent $e
     */
    protected function setRequestNames(MvcEvent $e)
    {
        if ($this->requestNames) {
            return;
        }

        if ($this->layerName == null) {
        	die('Please set the $layerName on "'. get_class($this).'".');
        }

        $sm = $e->getApplication()->getServiceManager();

        $router = $sm->get('router');
        $request = $sm->get('request');
        $matchedRoute = $router->match($request);

        $params = $matchedRoute->getParams();

        $full_controller = $params['controller'];
        $module_array = explode('\\', $full_controller);

        $this->requestNames['module'] = $module_array[0];
        $this->requestNames['full_controller'] = $full_controller;
        $this->requestNames['layer'] = $this->layerName;
        $this->requestNames['controller'] = $module_array[3];
        $this->requestNames['action'] = $params['action'];
        $this->requestNames['route'] = $matchedRoute->getMatchedRouteName();
    }

}