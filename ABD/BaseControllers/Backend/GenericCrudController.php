<?php namespace ABD\BaseControllers\Backend;

use ABD\BaseControllers\BackendController;

abstract class GenericCrudController extends BackendController {
	
	/**
	 * Set the Route Name used by this controller
	 *
	 * @var string
	 */
	protected $routeName;

	/**
	 * Name this Controller to show in title
	 *
	 * @var string
	 */
	protected $controllerTitle;

	/**
	 * Main Entity for this controller
	 *
	 * @var string
	 */
	protected $mainEntity;

	/**
	 * Main Form for this controller
	 *
	 * @var string
	 */
	protected $mainForm;

	/**
	 * Name of the table columns to view in list page
	 *
	 * @var array
	 */
	protected $tableColumns = [];

	/**
	 * Choose whether to use the normal view template or not
	 *
	 * @var boolean
	 */
	protected $useRegularViewTemplate = false;

    /**
     * List Items
     *
     * @return Zend\View\Model\ViewModel
     */
	public function indexAction()
	{
        return $this->render([
            'list' => $this->getRepository($this->mainEntity)->findAll(),
            'tableColumns' => $this->tableColumns,
            'pageTitle' => $this->controllerTitle . ' List',
            'routeName' => $this->routeName,
            'formLink' => $this->url()->fromRoute($this->routeName,['action' => 'form']),
            'deleteLink' => $this->url()->fromRoute($this->routeName,['action' => 'delete']),
        ], [
        	'template' => 'backend/list'
        ]);
	}

    /**
     * Form Page
     *
     * @return Zend\View\Model\ViewModel
     */
    public function formAction()
    {
        $id = $this->params()->fromRoute('id');
	    $form  = new $this->mainForm();
	    $formMode = 'add';

	    // Check for if Add or Edit Form Mode
        if ($id !== NULL)
        {
        	$item = $this->getEntityManager()->find($this->mainEntity, $id);
	        if (!$item)
	        {
	            return $this->redirect()->toRoute($this->routeName);
	        }

        	$form->bind($item);
        	$formMode = 'edit';
        }
        else
        {
        	$item = new $this->mainEntity();	
        }

        // On Post Submit
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $form->setInputFilter($item->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid())
            {
                if ($formMode == 'add')
                {
                	$item->exchangeArray($form->getData());
	            	$this->getEntityManager()->persist($item);
                }

                $this->getEntityManager()->flush();

                // Redirect to list
                return $this->redirect()->toRoute($this->routeName);
            }
        }
        
        return $this->render([
            'id' => $id,
            'backLinkUrl' => $this->url()->fromRoute($this->routeName),
            'form' => $form,
            'formMode' => $formMode,
            'formUrl' => $this->url()->fromRoute($this->routeName,['action' => 'form','id' => $id]),
            'pageTitle' => ucfirst($formMode).' '.$this->controllerTitle,
        ], [
        	'template' => 'backend/form'
        ]);

    }

    /**
     * Delete Item
     *
     * @return Redirect
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        if ($request->isPost())
        {
        	$id = (int) $this->params()->fromRoute('id', 0); 
 
            $id = (int) $request->getPost('id');
            $item = $this->getEntityManager()->find($this->mainEntity, $id);
            if ($item)
            {
                $this->getEntityManager()->remove($item);
                $this->getEntityManager()->flush();
            }
 
            return $this->redirect()->toRoute($this->routeName);
        }
    }

}