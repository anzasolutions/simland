<?php

/**
 * Encapsulate and manipulate the application requests.
 * 
 * @author anza
 */
class RequestHandler
{
	private $type;
	public $container;
	
    protected static $instance; // once initialized keep an instance of the RequestHandler
	
	public function RequestHandler()
	{
		$this->type = $_SERVER['REQUEST_METHOD'];
		$this->fillValues();
	}
	
	/**
	 * Creates single for whole application RequestHandler object.
	 * Singleton pattern implementation.
	 * 
	 * @return RequestHandler Either existing or new.
	 */
    public static function getInstance()
    {
    	if (!self::$instance)
    	{
    		self::$instance = new RequestHandler();
    	}
    	return self::$instance;
    }
	
	/**
	 * Particular type of request is aggregated locally.
	 * 
	 * @return void
	 */
	private function fillValues()
	{
		if ($this->type == 'POST')
		{
			$requestSource = $_POST;
		}
		else if ($this->type == 'FILES')
		{
			$requestSource = $_FILES;
		}
		else if ($this->type == 'COOKIES')
		{
			$requestSource = $_COOKIES;
		}
		else if ($this->type == 'SERVER')
		{
			$requestSource = $_SERVER;
		}
		else if ($this->type == 'GET')
		{
			$requestSource = $_GET;
		}
		
		foreach ($requestSource as $key => $value)
		{
			$this->container[$key] = $value;
		}
	}
	
	/**
	 * Check whether request contains specific set of keys.
	 * Even single wrong key fail the check.
	 * 
	 * @param array $keys Array of key strings to be checked.
	 * @return boolean True if request contains all provided key strings.
	 */
	public function hasKeys($keys)
	{
		foreach ($keys as $value)
		{
			if (!array_key_exists($value, $this->container))
			{
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Enriched version of hasKeys.
	 * Checks whether request contains specific key(s) string or array passed to method.
	 * Condition must be true in full to success the check.
	 * 
	 * @param mixed $keys Array set of keys or key string to check.
	 * @return boolean Condition must be true in full to success the check.
	 */
	//TODO: should hasKeys be replaced by this method or maybe below mechanism applied to hasKeys and hasKey to be removed?
	public function hasKey($keys)
	{
		$hasKey = true;
		
		if (is_string($keys))
		{
			if (!array_key_exists($keys, $this->container))
			{
				return false;
			}
		}
		else if (is_array($keys))
		{
			foreach ($keys as $value)
			{
				if (!array_key_exists($value, $this->container))
				{
					return false;
				}
			}
		}
		else
		{
			$hasKey = false;
		}
		
		return $hasKey;
	}
	
	//TODO: is this method really necessary?
	public function flush()
	{
		echo 'unsetting';
		unset($_REQUEST);
		unset($_POST);
	}
}

?>