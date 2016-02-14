<?php

/**
 * Produce required type of DAO.
 * 
 * @author anza
 */
class DAOFactory
{
    protected $registry;
    
    public function DAOFactory($registry)
    {
    	$this->registry = $registry;
    }
    
	public function getDAO($dao)
	{
		$daoName = $dao . "DAO";
		$dao = new $daoName($this->registry->db, $dao);
		return $dao;
	}
}

?>