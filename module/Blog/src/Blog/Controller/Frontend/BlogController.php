<?php namespace Blog\Controller\Frontend;

use ABD\BaseControllers\FrontendController;

class BlogController extends FrontendController {

    /**
     * List Items
     *
     * @return ViewModel
     */
	public function indexAction()
	{
        return $this->render([
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

        return $this->render([
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
        return $this->render();
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
        return $this->render();
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