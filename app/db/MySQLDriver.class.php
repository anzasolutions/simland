<?php

/**
 * Encapsulate PHP MySQLi extension.
 * Used to operate only on MySQL type database.
 * 
 * @author anza
 */
class MySQLDriver extends DBDriver
{
	/**
	 * Initialize single MySQLDriver object.
	 * Singleton pattern implementation.
	 * 
	 * @return MySQLDriver Single instance of a MySQLDriver object.
	 */
    public static function getInstance()
    {
    	if (!self::$instance)
    	{
    		self::$instance = new MySQLDriver();
    	}
    	return self::$instance;
    }
    
	/* (non-PHPdoc)
	 * @see app/db/DBDriver#connect()
	 */
	public function connect()
	{
		try
		{
			$this->connection = mysqli_init();
			$this->connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
			$this->connection->real_connect($this->hostname, $this->username, $this->password, $this->database);
			
			if ($this->connection->connect_error)
			{
				throw new ConnectionException("Cannot connect to database!");
			}
		}
		catch (Exception $e)
		{
			echo $e->getTrace();
		}
	}
	
	/* (non-PHPdoc)
	 * @see app/db/DBDriver#execute($sql)
	 */
	public function execute($sql)
	{
		$this->result = $this->connection->query($sql);
	    $_SESSION['queries']++; // for DEBUG ONLY and to be removed or handled more priopriate way!
	}
	
	/* (non-PHPdoc)
	 * @see app/db/DBDriver#count()
	 */
	public function count()
	{
		return $this->result->num_rows;
	}
	
	/* (non-PHPdoc)
	 * @see app/db/DBDriver#escape($string)
	 */
	public function escape($string)
	{
		return $this->connection->real_escape_string($string);
	}
}

?>