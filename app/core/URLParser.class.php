<?php

/**
 * Obtain and parse URL address.
 * Used to extract controllers and actions.
 * This is application router.
 * 
 * @author anza
 * @since 2010-02-17
 */
class URLParser
{
	const TRIM_PATTERN = ' /\\'; // selection of unwanted characters
	const SEPARATOR_SLASH = '/'; // separator used during the url parsing
	
	private $url;
	private $controller;
	private $actions;
	
	public function URLParser()
	{
		if (isset($_GET['action'])) {
			$this->url = $_GET['action'];
		}
		$this->trim();
		$this->parse();
	}
	
	/**
	 * Manipulate the url in order to find and extract controller and its actions.
	 * 
	 * @return void
	 */
	private function parse()
	{
		// check if the url's length is more than 0 
		if (strlen($this->url) > 0)
		{
			// check if the url contains at least one slash
			if (strpos($this->url, self::SEPARATOR_SLASH) != null)
			{
				// create array containing unchecked controller and its actions
				$elements = explode(self::SEPARATOR_SLASH, $this->url);
				
				// assigns first element of array to unchecked controller
				$this->controller = $elements[0];
				
				// remove controller from an array of url elements
				array_shift($elements);
				
				// assign the rest of the url elements to the array of actions 
				$this->actions = $elements;
			}
			else
			{
				// the url has one word so assuming it's unchecked controller 
				$this->controller = $this->url;
			}
		}
	}
	
	/**
	 * Trim the url from all unwanted characters.
	 * 
	 * @return void
	 */
	private function trim()
	{
		$this->url = trim($this->url, self::TRIM_PATTERN);
	}
	
	/**
	 * Provide unchecked controller extracted from the url.
	 * 
	 * @return string Current controller.
	 */
	public function getController()
	{
		return $this->controller;
	}
	
	/**
	 * Provide unchecked actions extracted from the url.
	 * 
	 * @return array Current controller's actions.
	 */
	public function getActions()
	{
		return $this->actions;
	}
}

?>