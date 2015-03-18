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

        $this->setLayerLayout();

        return parent::onDispatch($e);
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
     * Get Entity Repository
     *
     * @param  string $entity
     * @return Entity
     */
    protected function getRepository($entity)
    {
        return $this->getEntityManager()->getRepository($entity);
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
     * Get the view file path of the current request
     *
     * @return string
     */
    private function getViewTemplatePath()
    {
    	if (!$this->requestNames) {
    		$this->setRequestNames();
    	}
    	
    	return strtolower(
    		$this->requestNames['module'].'/'.
    		$this->requestNames['layer'].'/'.
    		$this->requestNames['controller'].'/'.
    		$this->requestNames['action']
    	);	
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
    	$viewModel = new ViewModel($variables, $options);
    	$viewModel->setTemplate($this->getViewTemplatePath())
                    ->setVariables([
                        'requestNames' => $this->requestNames,
                    ]);

    	return $viewModel;
    }

    /**
     * Respond with JSON
     *
     * @param  array  $json
     * @return string
     */
    protected function respondJson(array $json)
    {
        $response = $this->getResponse();
        
        $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
        $response->setContent(json_encode($json));
        
        return $response;
    }

    /**
     * Set Layer Layout for current request
     *
     * @return  void
     */
    private function setLayerLayout()
    {
    	$this->layout($this->getLayerLayout());
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

        // Get Route and Params
        $sm = $e->getApplication()->getServiceManager();
        $router = $sm->get('router');
        $request = $sm->get('request');
        $route = $router->match($request)->getMatchedRouteName();
        $params = $matchedRoute->getParams();

        // Split full controller path
        $module_array = explode('\\', $params['controller']);

        // Set to requestNames
        $this->requestNames['module'] = array_shift($module_array);
        $this->requestNames['full_controller'] = $params['controller'];
        $this->requestNames['layer'] = $this->getLayerName();
        $this->requestNames['controller'] = array_pop($module_array);
        $this->requestNames['action'] = $params['action'];
        $this->requestNames['route'] = $route;
    }

}