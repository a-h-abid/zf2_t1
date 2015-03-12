<?php namespace Blog\Controller\Frontend;

use ABD\BaseControllers\BackendController;
use Zend\View\Model\ViewModel;

class BlogController extends BackendController {

    /**
     * List Items
     *
     * @return ViewModel
     */
	public function indexAction()
	{
        return new ViewModel([
            'blogs' => $this->entity('Blog\Entity\Blog')->findAll(),
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

        $blog = $this->entity('Blog\Entity\Blog')->find($id);

        if ($blog == null)
        {
            // Throw 404 Page Not Found
            return $this->pageNotFound();
        }

        return new ViewModel([
            'blog' => $blog,
        ]);
    }


    /**
     * Create Item Form Page
     *
     * @return ViewModel
     */
    public function addAction()
    {
        return new ViewModel();
    }


    /**
     * Add Posted Item
     *
     * @return Redirect
     */
    public function storeAction()
    {
        return $this->redirect()->toRoute('blog');
    }


    /**
     * Edit Item Form Page
     *
     * @return ViewModel
     */
    public function editAction()
    {
        return new ViewModel();
    }


    /**
     * Update Posted Item
     *
     * @return Redirect
     */
    public function updateAction()
    {
        return $this->redirect()->toRoute('blog');
    }


    /**
     * Delete Item
     *
     * @return Redirect
     */
    public function deleteAction()
    {
        return $this->redirect()->toRoute('blog');
    }

}