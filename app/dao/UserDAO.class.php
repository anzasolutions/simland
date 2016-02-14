<?php

/**
 * Manipulates User object in database.
 * 
 * @author anza
 * @since 2010-04-11
 */
class UserDAO extends DAO
{
	/**
	 * Retrieve from DB a user based on provided credentials.
	 * 
	 * @param string $login
	 * @param string $password
	 * @return User Single user found in DB.
	 */
	/*public function getExistingUser($login, $password)
	{
		$login = $this->db->escape($login);
		$password = $this->db->escape($password);
		
		$sql = "SELECT login, password, id
				FROM user
				WHERE login = '$login'
				AND password = '$password'
				LIMIT 0, 1";
		
		$users = $this->execute($sql);
		
		if (count($users) > 0)
		{
			return $users[0];
		}
	}*/

	public function findUserByLogin($user)
	{
		$sql = "SELECT id, login, firstname, lastname, email, online, gender, birthdate, avatar, lastActive
				FROM user
				WHERE login = '{$user->getLogin()}'
				AND password = '{$user->getPassword()}'
				LIMIT 0, 1";
		
		$users = $this->execute($sql);		
		return $result = count($users) > 0 ? $users[0] : null;
	}

	public function findUserByLoginAndIsActive($user)
	{
		$sql = "SELECT id, login, firstname, lastname, email, online, gender, birthdate, avatar, lastActive
				FROM user
				WHERE login = '{$user->getLogin()}'
				AND password = '{$user->getPassword()}'
				AND active = '{$user->isActive()}'
				LIMIT 0, 1";
		
		echo $sql;
		
		$sql2 = "UPDATE user  
				SET lastActive = '{$user->getLastActive()}' 
				WHERE login = '{$user->getLogin()}'";
		
		$findUser = $this->execute($sql);
		
		$validUser = '';
		if ($isUserExists = count($findUser))
		{
			$updateUserActivity = $this->execute($sql2);
			$validUser = $findUser[0];
		}
		
		return $validUser;
	}
	
	public function findUserById($id)
	{
		$sql = "SELECT id, login, firstname, lastname, email, online, gender, birthdate, avatar, lastActive
				FROM user
				WHERE id = '{$id}'
				LIMIT 0, 1";
		
		$users = $this->execute($sql);
		
		if (count($users) > 0)
		{
			return $users[0];
		}
	}
	
	public function getLatestActiveUsers($howMany)
	{
		$sql = "SELECT id, login, firstname, lastname, email, online, gender, birthdate, avatar, lastActive
				FROM user
				ORDER BY lastActive
				DESC
				LIMIT 0, {$howMany}";
		
		$users = $this->execute($sql);
		return $result = count($users) > 0 ? $users : null;
	}
	
	public function findByIdSet($idSet)
	{
		$ids = Arrays::toStringSQL($idSet, ",");
		
		$sql = "SELECT id, login, firstname, lastname, email, online, gender, birthdate, avatar, lastActive
				FROM user 
				WHERE id in ({$ids})";
		
		$users = $this->execute($sql);
		return $result = count($users) > 0 ? $users : null;
	}
	
	/* (non-PHPdoc)
	 * @see app/dao/DAO#save($vo)
	 * @throws DuplicateException On attempt to insert the same credentials.
	 */
	public function save($user)
	{
		if ($user->getId() != '')
		{
			$currentUser = $this->findUserById($user->getId());
		}
		
		if (count($currentUser) > 0)
		{
			$sql = "UPDATE user SET 
				   	password = '{$user->getPassword()}', 
				   	firstname = '{$user->getFirstname()}', 
				   	lastname = '{$user->getLastname()}', 
				   	email = '{$user->getEmail()}', 
				   	online = '{$user->isOnline()}', 
				   	gender = '{$user->getGender()}', 
				   	avatar = '{$user->hasAvatar()}', 
				   	active = '{$user->isActive()}', 
				   	visitNumber = '{$user->getVisitNumber()}', 
				   	lastActive = '{$user->getLastActive()}', 
				   	latestIP = INET_ATON('{$user->getLatestIP()}') 
                	WHERE id = '{$user->getId()}'";
		}
		else
		{
			$sql = "INSERT INTO user (login, password, firstname, lastname, email, online, gender, birthdate, avatar, active, visitNumber, lastActive, latestIP)
					VALUES ('{$user->getLogin()}', 
							'{$user->getPassword()}', 
							'{$user->getFirstname()}', 
							'{$user->getLastname()}', 
							'{$user->getEmail()}', 
							'{$user->isOnline()}', 
							'{$user->getGender()}', 
							'{$user->getBirthdate()}', 
							'{$user->hasAvatar()}', 
							'{$user->isActive()}', 
							'{$user->getVisitNumber()}', 
							'{$user->getLastActive()}', 
							INET_ATON('{$user->getLatestIP()}'))";
        }
            
		$this->db->execute($sql);
		$affectedRows = $this->db->connection->affected_rows;
		
		if (mysqli_error($this->db->connection) != null)
		{
			throw new DuplicateException(mysqli_error($this->db->connection));
		}
		
        return $affectedRows;
	}
	
	//TODO: to be defined
	public function delete($user)
	{
		
	}
}

?>