<?php namespace Blog\Controller\Backend;

use ABD\BaseControllers\BackendController;
use Blog\Entity\Blog;
use Blog\Form\BlogForm;

class BlogController extends BackendController {

    /**
     * List Items
     *
     * @return Zend\View\Model\ViewModel
     */
	public function indexAction()
	{
        return $this->render([
            'blogs' => $this->getRepository('Blog\Entity\Blog')->findAll(),
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

        $blog = $this->getRepository('Blog\Entity\Blog')->find($id);

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
	    $form  = new BlogForm();
	    $formMode = 'add';

	    // Check for if Add or Edit Form Mode
        if ($id !== NULL)
        {
        	$blog = $this->getEntityManager()->find('Blog\Entity\Blog', $id);
	        if (!$blog)
	        {
	            return $this->redirect()->toRoute('administrator/blog');
	        }

        	$form->bind($blog);
        	$formMode = 'edit';
        }
        else
        {
        	$blog = new Blog();	
        }

        // On Post Submit
        $request = $this->getRequest();
        if ($request->isPost())
        {
            $form->setInputFilter($blog->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid())
            {
                if ($formMode == 'add')
                {
                	$blog->exchangeArray($form->getData());
	            	$this->getEntityManager()->persist($blog);
                }

                $this->getEntityManager()->flush();

                // Redirect to list
                return $this->redirect()->toRoute('administrator/blog');
            }
        }

        return $this->render([
            'id' => $id,
            'form' => $form,
            'formMode' => $formMode,
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
            $blog = $this->getEntityManager()->find('Blog\Entity\Blog', $id);
            if ($blog)
            {
                $this->getEntityManager()->remove($blog);
                $this->getEntityManager()->flush();
            }
 
            // Redirect to list of albums
            return $this->redirect()->toRoute('administrator/blog');
        }
    }

}