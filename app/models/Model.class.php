<?php

/**
 * Base model class. Responsible for common business logic.
 * Consists of all common methods and properties for all models.
 * 
 * @author anza
 */
class Model
{
	public $db; // database connection handle
	public $dao; // current DAO object in use
	
	public function Model($registry)
	{
		$this->db = $registry->db;
		$this->dao = $registry->dao;
	}
	
	//TODO: implementing this method use too much resources
	//TODO: to be replaced by a search mechanism form?
	public function countAllUsers()
	{
		$sql = 'SELECT login 
				FROM user';
		
		//$sql = $this->db->escape($sql);
		$this->db->execute($sql);
		return $this->db->count();
	}

	public function getUserByProfileNumber($profileNumber)
	{
		$dao = $this->dao->getDAO("User");
		return $dao->findUserById($profileNumber);
	}
}

?>