<?php namespace Blog\Form;

use Zend\Form\Form;


class BlogForm extends Form {

	public function __construct($name = 'blog')
	{
		// we want to ignore the name passed
		parent::__construct($name);
		
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		$this->add(array(
			'name' => 'title',
			'type' => 'Text',
			'options' => array(
				'label' => 'Title',
			),
		));
		$this->add(array(
			'name' => 'body',
			'type' => 'Text',
			'options' => array(
				'label' => 'Body',
			),
		));
		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'attributes' => array(
				'value' => 'Save',
				'id' => 'submit-button',
			),
		));
	}

}
