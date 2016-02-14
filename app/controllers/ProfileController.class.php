<?php

class ProfileController extends Controller
{
	private $actionsAdmin = array('edit');
	private $actionsProfile = array(); // is this line necessary?
	
	protected $userProfile;

	public function execute()
	{
		//TODO: this call should be Profile specific, or used also by other controllers?
		$this->createProfileUser();
		//TODO: This is terrible handling and MUST be improved to very nice and easy form!
//		if ($this->isUserProfile())
		if ($this->isActionInteger(0))
		{
		
			if ($this->isActionInteger(2) || $this->isActionInteger(3))
			{
				if (!in_array($this->actions[1], $this->actionsProfile) || sizeof($this->actions) > 4)
				{
					die ('404 Not Found');
					return false;
				}
				$this->currentAction = 'gallery';
			}
			else
			{
				$this->validateActions($this->actionsProfile, 1);
			}
		}
		else if ($this->isActionInteger(1))
		{
//			echo 'pupu';
			$this->currentAction = 'gallery';
		}
		else
		{
			$this->validateActions($this->actionsAdmin, 0);
		}
//		$this->currentAction = 'gallery';
//		print_r($this->actions);
//		
//		if ($this->isActionInteger(2))
//		{
//			echo 'pupu';
//			$this->currentAction = 'gallery';
//		}
		
		$this->dispatch($this->currentAction);
		
		new ProfileView($this->registry, $this->currentAction, $this->model);
	}
	
	/* (non-PHPdoc)
	 * @see app/controllers/Controller#index()
	 */
	//TODO: this must be a front page processing, so below user detection must be extracted to specific an method for all in Profile.
	public function index()
	{
		
	}
}

?>