<?php

class MainController extends Controller
{
	private $allowed = array();
	
	public function execute()
	{
		$this->validateActions($this->allowed, 0);
		
		$this->dispatch($this->currentAction);
		
		new MainView($this->registry, $this->currentAction, $this->model);
	}
	
	public function index()
	{
	}
}

?>