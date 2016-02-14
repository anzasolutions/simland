<?php

/**
 * Initialize requested controller.
 * 
 * @author anza
 * @since 2010-05-24
 */
class Router
{
	public $registry;
	
    private static $instance;
	
	public function Router($registry)
	{
		$this->registry = $registry;
	}
    
    /**
     * Ensure the Router object is a singleton.
     * 
     * @return Router single instance.
     * @author anza
     */
    public static function getInstance($registry)
    {
    	if (!self::$instance)
    	{
    		self::$instance = new Router($registry);
    	}
    	return self::$instance;
    }
	
	/**
	 * Load and execute controller directly.
	 *
	 * @author anza
	 */
	public function loader()
	{
		$controller = ControllerFactory::create($this->registry);
		$controller->execute();
	}
}

?>