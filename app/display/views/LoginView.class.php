<?php

/**
 * Login view.
 * Prepare login view properties for display using login templates.
 * 
 * @author anza
 */
class LoginView extends View
{
	public function index()
	{
		$this->view->latest_six = $this->helper->getLatestLogin();
		$this->view->latest_photos = $this->helper->getLatestPhotoAdded();
		$this->view->show('login');
	}
	
	// @Override
	public function header()
	{
		// creating form date selector
		$dateGenerator = new SelectDateGenerator($this->request);
		$this->view->selectDate = $dateGenerator->generateSelectDate();
		
		// creating form gender selector
		$genderGenerator = new SelectGenderGenerator($this->request);
		$this->view->selectGender = $genderGenerator->generateSelectGender();
		
		$this->view->login_register_form = $this->getTemplate('login_register_form');
		$this->view->login_auth_form = $this->getTemplate('login_auth_form');
		$this->view->register_link = $this->html->linkBegin(BASE_URL . 'login/register') . MessageBundle::getMessage('link.registration.value') . $this->html->linkEnd();
		parent::header();
	}
	
	/**
	 * Retrieves request from controller and build priopriate view output.
	 * @return void
	 */
	public function auth()
	{
		// check if any key in request is of error type
		if ($this->request->hasKey(ErrorEnum::ERROR))
		{
			// setting general error message and view style for a template
			$this->view->authentication_message = MessageBundle::getMessage('form.validation.field.incorrect');
			$this->view->authentication_message_class = ErrorEnum::ERROR;
			
			// check if a more specific error occured...
			if ($this->request->hasKey(ErrorEnum::VALIDATION))
			{
				// ...and set a message for a template or...
				$this->view->authentication_message = MessageBundle::getMessage('form.validation.field.incorrect.values');
			}
			else if ($this->request->hasKey(ErrorEnum::USER_INCORRECT))
			{
				// ...set another message for a template :)
				$this->view->authentication_message = MessageBundle::getMessage('form.validation.field.incorrect.user');
			}
			
			// authentication form values processing
			foreach ($this->request->container as $key => $value)
			{
				// setting form values
				$this->view->$key = $value;
				
				// in case of empty value...
				if (empty($value))
				{
					// ...form input is properly styled
					$errorStyle = $key . ErrorEnum::STYLE_SUFFIX;
					$this->view->$errorStyle = ErrorEnum::STYLE_COLOR;
				}
				
				// assign a hint to a form field
				$hintName = $key . '_hint';
				$this->view->$hintName = MessageBundle::getMessage('form.validation.field.register.hint.' . $key);
			}
		}
		
		// display template with the view assigned values
		$this->view->show($this->currentAction);
	}
	
	/**
	 * Retrieves request from controller and build priopriate view output.
	 * @return void
	 */
	public function register()
	{
		// check if any key in request is of error type
		if ($this->request->hasKey(ErrorEnum::ERROR))
		{
			// setting general error message and view style for a template
			$this->view->register_message = MessageBundle::getMessage('form.validation.field.incorrect');
			$this->view->register_message_class = ErrorEnum::ERROR;
			
			// if error is regarding user inputs this clause is enetered 
			if ($this->request->hasKey(ErrorEnum::USER))
			{
				// is there a problem with login input...
				if ($this->request->hasKey(ErrorEnum::LOGIN))
				{
					$this->view->register_message = MessageBundle::getMessage('form.validation.field.register.login.exists');
				}
				// ...or email?
				else if ($this->request->hasKey(ErrorEnum::EMAIL))
				{
					$this->view->register_message = MessageBundle::getMessage('form.validation.field.register.email.exists');
				}
			}
			// check if a form validation error occured...
			else if ($this->request->hasKey(ErrorEnum::VALIDATION))
			{
				echo 'KOKOO';
				$this->view->register_message = MessageBundle::getMessage('form.validation.field.incorrect.values');
			}
			
			// registration form values processing
			foreach ($this->request->container as $key => $value)
			{
				// setting form values
				$this->view->$key = $value;
				
				// in case of empty value...
				if (empty($value))
				{
					// ...form input is properly styled
					$errorStyle = $key . ErrorEnum::STYLE_SUFFIX;
					$this->view->$errorStyle = ErrorEnum::STYLE_COLOR;
				}
				
				// assign a hint to a form field
				$hintName = $key . '_hint';
				$this->view->$hintName = MessageBundle::getMessage('form.validation.field.register.hint.' . $key);
			}
		}
		// reaching this clause means all went fine
		else if ($this->request->hasKey('success'))
		{
			$this->view->register_message = MessageBundle::getMessage('form.validation.field.register.success');
			$this->view->register_message_class = 'success';
		}
		// display template with the view assigned values
		$this->view->show($this->currentAction);
	}
	
	//TODO: is it used anywhere at all? to be removed?
	public function success()
	{
		$this->view->show($this->currentAction);
	}
}

?>