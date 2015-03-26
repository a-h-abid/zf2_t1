<?php namespace Blog\Controller\Backend;

use ABD\BaseControllers\Backend\GenericCrudController;

class BlogController extends GenericCrudController {

	/**
	 * Set the Route Name used by this controller
	 *
	 * @var string
	 */
	protected $routeName = 'administrator/blog';

	/**
	 * Name this Controller to show in title
	 *
	 * @var string
	 */
	protected $controllerTitle = 'Blog';

	/**
	 * Main Entity for this controller
	 *
	 * @var string
	 */
	protected $mainEntity = 'Blog\Entity\Blog';

	/**
	 * Main Form for this controller
	 *
	 * @var string
	 */
	protected $mainForm = 'Blog\Form\BlogForm';

	/**
	 * Name of the table columns to view in list page
	 *
	 * @var array
	 */
	protected $tableColumns = ['id','title'];

    /**
     * View Item
     *
     * @return ViewModel
     */
    public function showAction()
    {
        $this->useRegularViewTemplate = true;

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

}