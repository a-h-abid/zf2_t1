<?php namespace Blog\Controller\Backend;

use ABD\BaseControllers\BackendController;
use Blog\Entity\Blog;
use Blog\Form\BlogForm;

class BlogController extends BackendController {

	/**
	 * Set the Route Name used by this controller
	 *
	 * @var string
	 */
	private $routeName = 'administrator/blog';

	/**
	 * Name this Controller to show in title
	 *
	 * @var string
	 */
	private $controllerTitle = 'Blog';

	/**
	 * Main Entity for this controller
	 *
	 * @var string
	 */
	private $mainEntity = 'Blog\Entity\Blog';

	/**
	 * Main Form for this controller
	 *
	 * @var string
	 */
	private $mainForm = 'Blog\Form\BlogForm';


    /**
     * List Items
     *
     * @return Zend\View\Model\ViewModel
     */
	public function indexAction()
	{
        return $this->render([
            'list' => $this->getRepository($this->mainEntity)->findAll(),
            'tableColumns' => ['id','title'],
            'pageTitle' => 'Blogs List',
            'routeName' => $this->routeName,
            'formLink' => $this->url()->fromRoute($this->routeName,['action' => 'form']),
            'deleteLink' => $this->url()->fromRoute($this->routeName,['action' => 'delete']),
        ]);
	}


    /**
     * View Item
     *
     * @return ViewModel
     */
    public function showAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        $blog = $this->getRepository($this->mainEntity)->find($id);

        if ($blog == null)
        {
            // Throw 404 Page Not Found
            return $this->pageNotFound();
        }

        return $this->render([
            'blog' => $blog,
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
        
        //dd($this->url($this->routeName,['action' => 'form','id' => $id]));

        return $this->render([
            'id' => $id,
            'backLinkUrl' => $this->url()->fromRoute($this->routeName),
            'form' => $form,
            'formMode' => $formMode,
            'formUrl' => $this->url()->fromRoute($this->routeName,['action' => 'form','id' => $id]),
            'pageTitle' => ucfirst($formMode).' '.$this->controllerTitle,
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
            $blog = $this->getEntityManager()->find($this->mainEntity, $id);
            if ($blog)
            {
                $this->getEntityManager()->remove($blog);
                $this->getEntityManager()->flush();
            }
 
            // Redirect to list of albums
            return $this->redirect()->toRoute($this->routeName);
        }
    }

}