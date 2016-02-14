<?php

/**
 * Base database driver.
 * Consists of all common methods and properties for all database drivers.
 * 
 * @abstract
 * @author anza
 */
abstract class DBDriver
{
	//TODO: to be replaced by more generic solution?
	//TODO: should this be located separately in each driver?
	const DB_DEV = 'app/config/xml/db_dev.xml'; // setting of database in use 
	const DB_PROD = 'app/config/xml/db_prod.xml'; // setting of database in use
	const DB_PROPERTIES = self::DB_DEV;
	
	public $connection; // database connection handle
	protected $hostname; // database hostname including server name and port
	protected $username; // user to be used for connection
	protected $password; // password to be used for connection
	protected $database; // current database in use
	public $result; // result of the latest query 
    
    protected static $instance; // once initialized keep an instance of a current driver 
	
	public function DBDriver()
	{
		$_SESSION['queries'] = 0; // for DEBUG ONLY and to be removed or handled more priopriate way!
		$this->loadDBProperties();
		$this->connect();
	}
	
	/**
	 * Explicitly called connects to a database.
	 */
	public abstract function connect();
	
	/**
	 * Executes SQL query against database.
	 * 
	 * @abstract
	 * @param string $sql SQL query to be executed against database.
	 */
	public abstract function execute($sql);
	
	/**
	 * Counts elements based on provided query
	 * 
	 * @abstract
	 */
	//TODO: is it necessary?
	//TODO: definition to be precised.
	public abstract function count();
	
	/**
	 * Escapes non-ASCII characters before input to database.
	 * String is immunized and more secure for further use.
	 * 
	 * @abstract
	 * @param string $string String to be escaped and used within SQL query.
	 */
	public abstract function escape($string);
	
	/**
	 * Database settings loader.
	 * Read properly formed XML file and set driver settings. 
	 * 
	 * @return void
	 */
	//TODO: should this be a part of more generic solution?
	//TODO: for example Loader object containing static loader methods for different loading purposes?
	public function loadDBProperties()
	{
		$xml = simplexml_load_file(self::DB_PROPERTIES);
		$this->hostname = (string)$xml->hostname;
		$this->username = (string)$xml->username;
		$this->password = (string)$xml->password;
		$this->database = (string)$xml->database;
	}
}

?>