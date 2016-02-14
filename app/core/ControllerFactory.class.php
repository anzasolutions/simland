<?php

/**
 * Create and dispatch controllers.
 * This is application's front controller.
 * 
 * @author anza
 * @since 2010-02-19
 */
class ControllerFactory
{
	private static $inSession = array('main', 'profile', 'gallery'); // controllers allowed during session
	private static $noSession = array('login'); // controllers allowed when no session
	
	/**
	 * Initialize demanded controller.
	 * 
	 * @param Registry $registry Registry object.
	 * @return Controller | void
	 * @author anza
	 */
	public static function create($registry)
	{
		$parser = new URLParser();
		
		$controller = $parser->getController();
		$actions = $parser->getActions();
		
		if ($controller == null)
		{
			$controller = self::$inSession[0];
		}
		
		if ($controller == 'logout')
		{
			$registry->session->destroy();
			$controller = self::$inSession[0];
		}
		
		$controllerName = $controller . 'Controller';
		$modelName = $controller . 'Model';
		
		$allowedControllers = $registry->session->isStarted() ? self::$inSession : self::$noSession;
		$target = $registry->session->isStarted() ? self::$inSession[0] : self::$noSession[0];
		
		if (in_array($controller, $allowedControllers))
		{
			$registry->controllerName = $controller;
			$controller = new $controllerName($actions, $registry);
			$controller->model = new $modelName($registry);
			return $controller;
		}
		else
		{
			Navigator::redirectTo($target);
		}
		
		
	}
}

?>