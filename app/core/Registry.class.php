<?php

/**
 * Core application components container.
 * Available in whole application.
 * 
 * @author anza
 * @since 2010-05-24
 */
class Registry
{
	private $vars = array();
	
	public function __construct()
	{
		//echo 'hi';
	}
	
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	public function __get($index)
	{
		return $this->vars[$index];
	}
}

?>