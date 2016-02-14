<?php

/**
 * Container of all template properties.
 * Interacts directly with html template files.
 * 
 * @author anza
 */
class Template
{
	private $registry; // handle to the Registry object
	private $vars = array(); // storage of template properties

	function Template($registry)
	{
		$this->registry = $registry;
	}
	
	/**
	 * Magical setter of template properties.
	 * 
	 * @param integer $index Position of the property in array.
	 * @param string $value Value of the given property.
	 * @return void
	 */
	public function __set($index, $value)
	{
		$this->vars[$index] = $value;
	}
	
	/**
	 * Find a template file based on given name and display it.
	 * Throws an exception if template file not found.
	 * 
	 * @param string $name Name of a template to be loaded.
	 * @return void
	 */
	function show($name)
	{
		// template path definition
		$path = PATH_TEMPLATES . $name . EXT_HTML;

		// check whether the template exists
		if (!file_exists($path))
		{
			throw new Exception('Template not found in ' . $path);
			return false;
		}

		// load properties into template
		foreach ($this->vars as $key => $value)
		{
			$$key = $value;
		}

		// display template file
		include ($path);
	}
}

?>
