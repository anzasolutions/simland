<?php

class MainView extends View
{
	public function index()
	{
	}
	
	// @Override
	public function header()
	{
		$this->view->top_info = $this->html->divClosed('top-back');
		$this->view->login_form = $this->getTemplate('welcome_avatar');
		parent::header();
	}
}

?>