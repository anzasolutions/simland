<?php

/**
 * Responsible for autoloading classes.
 * Newly created objects doesn't require explicit includes nor require calls.
 * 
 * @author anza
 * @since 2010-05-24
 */
class Autoloader
{
	const PATH_PROPERTIES = 'app/config/xml/paths.xml'; // setting of database in use
	
	/**
	 * Sets include path for autoloading.
	 * Register autoloading method.
	 *
	 * @author anza
	 */
	public static function init()
	{
		$xml = simplexml_load_file(Autoloader::PATH_PROPERTIES);
		
		foreach ($xml->location as $location)
		{
			set_include_path(get_include_path().PATH_SEPARATOR.'app/' . $location->path . '/');
		}
		
		spl_autoload_register('Autoloader::load');
	}
	
	/**
	 * Autoloading method.
	 * Responsible for loading of all objects.
	 *
	 * @param string $class Classname to be loaded
	 * @author anza
	 */
	public static function load($class)
	{
		$ucClass = ucfirst($class);
		require("${ucClass}.class.php");
	}
}

?>