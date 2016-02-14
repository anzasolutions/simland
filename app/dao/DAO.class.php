<?php

/**
 * Base Data Access Object.
 * Consists of all common methods and properties for all DAOs.
 * 
 * @author anza
 */
abstract class DAO
{
	protected $db; // database connection handle
	protected $vo; // current VO object to be manipulated

	public function DAO($db, $vo)
	{
		$this->db = $db;
		$this->vo = $vo;
	}
	
	/**
	 * Insert or update a VO object in database.
	 * 
	 * @abstract
	 * @param Object $vo VO object to be manipulated.
	 */
	public abstract function save($vo);
	
	/**
	 * Delete a VO object from database.
	 * 
	 * @abstract
	 * @param Object $vo VO object to be manipulated.
	 */
	public abstract function delete($vo);

	/**
	 * Execute provided query in order to return specific set of VO.
	 * Array of objects' returned only if not empty query result.
	 * 
	 * @param string $sql Query to be executed. 
	 * @return array Number of VO's for particular type of DAO. 
	 */
	public function execute($sql)
	{
		// execute query
		$this->db->execute($sql);
		
		// VO objects container
		$objects = array();
		
		// check if any result returned 
		if ($this->db->result->num_rows > 0)
		{
			// each returned database row is translated to stdClass
			while ($row = $this->db->result->fetch_object())
			{
				// specific VO is initialized
				$object = new $this->vo();
				
				// stdClass is iterated through each field and related value
				foreach ($row as $field => $value)
				{
					// VO is filled with data from stdClass using setters
					$setterName = 'set' . $field;
					$object->$setterName($value);
				}
				
				// filled VO is added to the container
				array_push($objects, $object);
			}
		}
		
		// return VO objects container
		return $objects;
	}
}

?>