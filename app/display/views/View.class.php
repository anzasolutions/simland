<?php

/**
 * Base view. Prepare view properties for display using templates.
 * Consists of all common methods and properties for all views.
 * 
 * @author anza
 */
abstract class View
{
	protected $registry;
	protected $currentAction;
	protected $currentController;
	protected $view;
	protected $model;
	protected $request;
	protected $html;
	protected $helper;
	
	//TODO: to be replaced by something nicer...
	protected $userMenuLinks = array('Home' => 'home',
									 'Profil' => 'profile',
									 'Poczta' => 'mail',
									 'Galeria' => 'gallery',
									 'Avatar' => 'avatar',
									 'Znajomi' => 'friends',
									 'Blog' => 'blog',
									 'Ustawienia' => 'settings');
	
	public function View($registry, $currentAction, $model)
	{
		$this->registry = $registry;
		$this->model = $model;
		$this->view = $this->registry->template;
		$this->request = $registry->request;
		$this->currentAction = $currentAction;
		$this->currentController = $registry->controllerName;
		$this->html = new HTMLBuilder();
		$this->helper = $this->getHelper();
		$this->header();
		$this->distpatch($currentAction);
		$this->footer();
	}
	
	/**
	 * Default view action.
	 * 
	 * @return void
	 */
	public function index()
	{
		$this->view->profile_fullname = $this->html->linkBegin(URL_PROFILE . $_SESSION['oUserProfile']->getId()) . $_SESSION['oUserProfile']->getFirstname() . ' ' . 
										$_SESSION['oUserProfile']->getLastname() . $this->html->linkEnd();
		$this->view->profile_avatar = $this->helper->getProfileAvatar();
		$this->view->profile_menu = $this->helper->getProfileMenu($this->currentAction, $this->currentController);
		$this->view->show('profile');
	}
	
	/**
	 * Default header used by all View objects.
	 * If necessary can be overwritten.
	 * 
	 * @return void
	 */
	public function header()
	{
		$this->view->top_info = $this->html->divClosed('top-back');
		$this->view->login_form = $this->getTemplate('login_form');
		
		// verify if user exists in session
		if (isset($_SESSION['oUser']) && $_SESSION['oUser'])
		{
			// assign user object properties to the header template fields 
			$this->view->user_id = $_SESSION['oUser']->getId();
			$this->view->user_login = $_SESSION['oUser']->getLogin();
			$this->view->user_firstname = $_SESSION['oUser']->getFirstname();
			$this->view->user_lastname = $_SESSION['oUser']->getLastname();
			
			// default woman (1) or man (2) avatar is assigned by default
			$this->view->user_avatar = URL_IMG . 'avatar-' . $_SESSION['oUser']->getGender() . EXT_PNG;
			
			// if user has avatar it's assigned to the user
			if ($_SESSION['oUser']->hasAvatar()) $this->view->user_avatar = URL_PHOTOS . $_SESSION['oUser']->getId() . '/avatar' . EXT_JPG;
			
			// after login the user menu will be shown
			if (!($this instanceof LoginView))
			{
				$this->view->user_menu = $this->buildUserMenu(); 
				$this->view->user_menu_panel = $this->getTemplate('user_menu_panel');
				$this->view->login_form = $this->getTemplate('welcome_avatar');
			}
		}
		// gets a sum of registered users
//		$this->view->total_users = $this->html->liBegin() . $this->html->linkBegin(URL_LOGIN, '', '', '', 'text-decoration: blink; font-weight: bold;') . 
		$this->view->total_users = $this->html->liBegin() . $this->html->linkBegin(URL_LOGIN, '', '', '', 'font-weight: bold;') . 
									MessageBundle::getMessage('link.label.search.friends') . ' (' . $this->model->countAllUsers() . ')' . $this->html->linkEnd() . $this->html->liEnd();
		
		// display the header template
		$this->view->show('header');
	}
	
	/**
	 * Invoke related footer template for display.
	 * Can be overwritten if necessary.
	 * 
	 * @return void
	 */
	public function footer()
	{
		$this->view->show('footer');
	}
	
	/**
	 * Calls view associated with current action.
	 * Default view is called if no action defined.
	 * 
	 * @param string $currentAction
	 * @return unknown_type
	 */
	public function distpatch($currentAction)
	{
		if ($currentAction == null)
		{
			$this->index();
		}
		else
		{
			$this->$currentAction();
		}
	}
	
	/**
	 * Instantiate related helper object.
	 * 
	 * @return mixed Related helper object if exists or empty string.
	 * @throws LogicException On missing helper class.
	 */
	protected function getHelper()
	{
		try
		{
			$helperName = get_class($this) . "Helper";
			if (class_exists($helperName))
			{
				return new $helperName($this->html, $this->model);
			}
		}
		catch (LogicException $e)
		{
			return "";
		}
	}
	
	/**
	 * Build user menu.
	 * 
	 * @return string Built user menu.
	 */
	protected function buildUserMenu()
	{
		$output = '';
		foreach ($this->userMenuLinks as $label => $link)
		{
			$linkIconName = str_replace("profile/", "", $link);
			$icon = URL_IMG_ICONS . $linkIconName . EXT_PNG;
			
			$output .= $this->html->liBegin() . $this->html->divBegin('icon', '', 'background: transparent url(' . $icon . ') no-repeat 0% 90%;');
			$output .= $this->html->divBegin('', 'left');
			$output .= $this->html->linkBegin(BASE_URL . $link) . $label;
			$output .= $this->html->linkEnd() . $this->html->divEnd() . $this->html->divEnd(). $this->html->liEnd();
		}
		
		return $output;
	}
	
	/**
	 * Generate full path to a template. 
	 * 
	 * @param string $template Template name.
	 * @return string Full path to a template.
	 */
	protected function getTemplate($template)
	{
		return PATH_TEMPLATES . $template . EXT_HTML;
	}
}

?>