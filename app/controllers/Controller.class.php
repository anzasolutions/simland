<?php

/**
 * Base controller.
 * Consists of all common methods and properties for all controllers.
 * 
 * @author anza
 * @since 2010-02-17
 */
abstract class Controller
{
	protected $actions;
	protected $session;
	protected $actionsNumber;
	protected $registry;
	protected $check;
	protected $currentAction;
	public $model;
	protected $view;
	protected $request;
	
	public function Controller($actions, $registry)
	{
		$this->initialize($actions);
		$this->registry = $registry;
		$this->request = $registry->request;
	}
	
	/**
	 * Main method of each controller.
	 * 
	 * @abstract
	 */
	public abstract function execute();
	
	/**
	 * Default action of each controller.
	 * 
	 * @abstract
	 */
	public abstract function index();
	
	/**
	 * Set up and prepare a controller environment.
	 * 
	 * @param array $actions Unvalidated array of actions.
	 * @return void
	 */
	protected function initialize($actions)
	{
		$this->setActions($actions);
		$this->countActions();
	}
	
	/**
	 * Assign URL actions to the current controller. 
	 * 
	 * @param array $actions Unvalidated array of actions.
	 * @return void
	 */
	public function setActions($actions)
	{
		$this->actions = $actions;
	}
	
	/**
	 * Print object name.
	 * 
	 * @return void
	 */
	public function toString()
	{
		echo get_class($this);
	}
	
	public function setSession($session)
	{
		$this->session = $session;
	}
	
	/**
	 * Count actions of current controller. 
	 * 
	 * @return void
	 */
	public function countActions()
	{
		$this->actionsNumber = count($this->actions);
	}
	
	/**
	 * Convert string to integer.
	 * 
	 * @param string $string Input string.
	 * @return int Converted value.
	 */
	public function convertToInt($string)
	{
		settype($string, "int");
		return $string;
	}
	
	public function isUserProfile()
	{
		$converted = $this->convertToInt($this->actions[0]);
		if ($converted != 0)
		{
			$this->actions[0] = $converted;
			return true;
		}
	}
	
	public function isActionInteger($action)
	{
		$converted = $this->convertToInt(isset($this->actions[$action]) ? $this->actions[$action] : '');
		if ($converted != 0)
		{
			$this->actions[$action] = $converted;
			return true;
		}
	}
	
	/**
	 * Verify all actions provided to controller.
	 * Even single wrong action fails whole validation process.
	 * Failed validation redirect user to 404 page.
	 * 
	 * @param array $allowedActions Allowed actions to be used with a controller.
	 * @param int $number Initial element of actions array.
	 * @return boolean True only if recursive walk through allowedArray succeed.
	 */
	public function validateActions($allowedActions, $number)
	{
		// check whether actions array limit has been reached 
		if ($number == $this->actionsNumber)
		{
			$this->check = true;
			return true;
		}
		
		// check whether next allowed sub-array exist
		// if action is not permitted the allowed sub-array is null 
		if ($allowedActions == null)
		{
			die ('404 Not Found');
			return false;
		}
		
		// check if action exist in $allowedActions as string or array key
		if (!in_array($this->actions[$number], $allowedActions))
		{
			if (!array_key_exists($this->actions[$number], $allowedActions))
			{
				die ('404 Not Found');
				return false;
			}
		}
		
		$this->currentAction = $this->actions[$number];
		
		// recurrence call with allowed sub-array and next action number
		if (isset($allowedActions[$this->actions[$number]])) {
			$this->validateActions($allowedActions[$this->actions[$number]], ++$number);
		}
	}
	
	//TODO: is this used anywhere?
	public function checkValidation()
	{
		return $this->check;
	}
	
	/**
	 * Retrieve current action.
	 * 
	 * @return string $this->currentAction Controller's current action.
	 */
	public function getCurrent()
	{
		return $this->currentAction;
	}
	
	/**
	 * Launch requested action of controller.
	 * Missing or incorrect action will be replaced by default one.
	 * 
	 * @param string $currentAction Action to be invoked on controller.
	 * @return void
	 */
	public function dispatch($currentAction)
	{
		if ($currentAction != null && method_exists($this, $currentAction))
		{
			$this->$currentAction();
		}
		else if (method_exists($this, "index"))
		{
			$this->index();
		}
	}
	
	/**
	 * Redirect to requested location.
	 * 
	 * @param string $location Requested location.
	 * @return void
	 */
	protected function redirectTo($location = null)
	{
		$location = $location == null ? BASE_URL : BASE_URL . $location;
		header("Location: " . $location);
	}
	
	//TODO: refactor and assign a comment
	protected function createProfileUser()
	{
		// by default User object to be used in profile display
		// is copied from currently logged in User
		$_SESSION['oUserProfile'] = $_SESSION['oUser'];
		$currentProfileNumber = $this->actions[0];
		
		// in case there's profile number defined in url
		if ($currentProfileNumber != 0)
		{
			// checking if session profile id matches action user id
			if ($currentProfileNumber != $_SESSION['oUserProfile']->getId())
			{
				// try to retrieve an User from database
				$user = $this->model->getUserByProfileNumber($currentProfileNumber);
				
				if ($user != null)
				{
					// on success an User is assigned to the profile User
					$_SESSION['oUserProfile'] = $user;
				}
				else
				{
					//TODO: needs to be handles more nice
					//TODO: for example redirect or error, add try/catch?
					// on failure the page is 404'd
					die ('404 Not Found');
				}
			}
		}
	}
}

?>