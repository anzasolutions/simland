<?php

/**
 * Gateway of the application.
 * Authorize and register users.
 * 
 * @author anza
 * @since 2010-02-17
 */
class LoginController extends Controller
{
	// actions allowed for this controller
	//TODO: should they be loaded in more generic way on LoginController object creation?
	private $allowedActions = array('auth', 'register');
	
	// controller's main method
	public function execute()
	{
		$this->validateActions($this->allowedActions, 0);
		
		$this->dispatch($this->currentAction);
		
		new LoginView($this->registry, $this->currentAction, $this->model);
	}
	
	/* (non-PHPdoc)
	 * @see app/controllers/Controller#index()
	 */
	public function index()
	{
	}
	
	/**
	 * Authenticates login attempt.
	 * On success session is started.
	 * 
	 * @throws FormValidationException On failed form validation.
	 * @return void
	 */
	public function auth()
	{
		// instance of related enumerated type
		$enum = new LoginEnum();
		
		// form elements to be processed
		if ($this->request->hasKeys($enum->constsToArray()))
		{
			// this is error signal to be sent to the view if authentication fails
			// if the authentication succeed the error signal will be unset
			$this->request->container[ErrorEnum::ERROR] = ErrorEnum::ERROR;
			
			// initialize validation object
			$validate = new Validator();
			
			// make sure the form elements are not empty
			if (!$validate->hasEmptyValues($this->request->container))
			{
				// form elements will be validated based on propriate rules
				$userInputs = array(LoginEnum::NAME => array($this->request->container[LoginEnum::NAME] => 'name'),
									LoginEnum::PASS => array($this->request->container[LoginEnum::PASS] => 'password'));
									
				try
				{
					// validation in progress (throws FormValidationException)
					$validate->userInputs($userInputs);
				
					// form elements gets nice variable names assignment
					$validLogin = $this->request->container[LoginEnum::NAME];
					$validPassword = $this->request->container[LoginEnum::PASS];
					
					// model authenticates user with provided details and return User on success
					$user = $this->model->authenticate($validLogin, $validPassword);
					
					// checks if a User object is not null
					if ($user != null)
					{
						// Users wants to be remembered?
						if ($this->request->hasKey('login_remember'))
						{
							$this->registry->session->setRemembered(true);
						}
						
						// open up sesame!
						$this->registry->session->start();
						$_SESSION['oUser'] = $user;
						
						// unset error signal
						unset($this->request->container[ErrorEnum::ERROR]);
						
						// leaving Login controller
						$this->redirectTo();
					}
					
					// at this point it's obvious the user with such credentials 
					// does not exist or awaits activation
					$this->request->container[ErrorEnum::USER_INCORRECT] = ErrorEnum::USER_INCORRECT;
					
				}
				catch (FormValidationException $e)
				{
					// in case of validation failure an error signal is send to the view 
					$this->request->container[ErrorEnum::VALIDATION] = '';
					
					// failed form element is cleared
					$this->request->container[$e->getFailedInput()]  = '';
				}
			}
		}
	}
	
	/**
	 * Register new user.
	 * 
	 * @throws FormValidationException On failed form validation.
	 * @throws DuplicateException On attempt to store in database new User with the same credentials.
	 * @throws Exception Print out any other exception message.
	 * @return void
	 */
	public function register()
	{
		// instance of related enumerated type
		$enum = new RegisterEnum();
		
		// form elements to be processed
		if ($this->request->hasKeys($enum->constsToArray()))
		{
			// this is error signal to be sent to the view if authentication fails
			// if the registration succeed the error signal will be unset
			$this->request->container[ErrorEnum::ERROR] = ErrorEnum::ERROR;
			
			// initialize validation object
			$validate = new Validator();
			
			// make sure the form elements are not empty
			if (!$validate->hasEmptyValues($this->request->container))
			{
				// form elements will be validated based on propriate rules
				$userInputs = array(RegisterEnum::FIRSTNAME => array($this->request->container[RegisterEnum::FIRSTNAME] => 'name'),
									RegisterEnum::LASTNAME => array($this->request->container[RegisterEnum::LASTNAME] => 'name'),
									RegisterEnum::LOGIN => array($this->request->container[RegisterEnum::LOGIN] => 'text'),
									RegisterEnum::EMAIL => array($this->request->container[RegisterEnum::EMAIL] => 'email'),
									RegisterEnum::PASSWORD => array($this->request->container[RegisterEnum::PASSWORD] => 'text'));

				try
				{
					// validation in progress (throws FormValidationException)
					$validate->userInputs($userInputs);
					
					// attempt to register new user (throws DuplicateException)
					$registerUser = $this->model->register($this->request->container);
				
					// if new user is created successfully 
					if ($registerUser > 0)
					{
						//TODO: send mail with notification
						
						//notification email is send with link to activate
						//this should be md5'ied combination of login and email
						//
						//$activationCode = md5($login . $email);
						//$mailer = Mailer();
						//$mailer->newMessage($email, $activationCode); $email => recepient, $activationCode => mail content
						//$mailer->send();;
						unset($this->request->container[ErrorEnum::ERROR]);
						$this->request->container['success'] = 'success';
					}
				}
				catch (FormValidationException $e)
				{
					// in case of validation failure an error signal is send to the view
					$this->request->container[ErrorEnum::VALIDATION] = '';
					
					// failed form element is cleared
					$this->request->container[$e->getFailedInput()]  = '';
				}
				catch (DuplicateException $e)
				{
					// user with existing crucial credentials (login and password) cannot be registered
					// propriate signal is send to the view
					$this->request->container[ErrorEnum::USER] = '';
					$this->request->container[ErrorEnum::ERROR . ucfirst($e->getField())] = ErrorEnum::ERROR . ucfirst($e->getField());
					$this->request->container['register_' . $e->getField()] = '';
				}
				catch (Exception $e)
				{
					// more general exception is thrown and message displayed
					echo $e->getMessage();
				}
			}
		}
	}
}

?>