<?php

/**
 * Consists of Login business logic.
 * 
 * @author anza
 */
class LoginModel extends Model
{
	/**
	 * Authenticates user based on provided credentials. 
	 * 
	 * @return array Set of latest logged in users.
	 */
	public function getLatestLogin()
	{
		$dao = $this->dao->getDAO("User");
		$vo = new User();
		return $dao->getLatestActiveUsers(14);
	}
	
	//TODO: refactor if necessary and add comment
	public function getLatestPhotoAdded()
	{
		$userDao = $this->dao->getDAO("User");
		$imageDao = $this->dao->getDAO("Image");

		$images = $imageDao->findLatest(30);
		$latestPhotos = array();
		
		foreach ($images as $image)
		{
			array_push($latestPhotos, $image->getUserId());
		}
		$idSet = array_unique($latestPhotos);
		$users = $userDao->findByIdSet($idSet);
		$imageMap = array();
	
		foreach ($images as $image)
		{
			$singleMap = array();
			foreach ($users as $user)
			{
				if ($image->getUserId() == $user->getId())
				{
//					$imageMap[$user] = $image;
					$singleMap = array($image, $user);
				}
			}
			array_push($imageMap, $singleMap);
		}
		
		return $imageMap;
	}
	
	/**
	 * Authenticates user based on provided credentials. 
	 * 
	 * @param string $login Valid string to be used as login value.
	 * @param string $password Valid string to be used as password value.
	 * @return User Object or null depends on retrieval output of user from database.
	 */
	public function authenticate($login, $password)
	{
		$dao = $this->dao->getDAO("User");
		
		$vo = new User();
		$vo->setLogin($this->db->escape($login));
		$vo->setPassword($this->db->escape($password));
		$vo->setActive(true);
		
		return $dao->findUserByLoginAndIsActive($vo);
	}
	
	/**
	 * Used to register new User.
	 * 
	 * @param array $request Register form Credentials to be used to register new User.
	 * @return integer Number of successfully affected rows in User table.
	 */
	public function register($request)
	{
		$login = $request[RegisterEnum::LOGIN];
		$password = md5($request[RegisterEnum::PASSWORD]);
		$firstname = $request[RegisterEnum::FIRSTNAME];
		$lastname = $request[RegisterEnum::LASTNAME];
		$email = $request[RegisterEnum::EMAIL];
		$gender = $request[RegisterEnum::GENDER];
		$year = $request[RegisterEnum::YEAR];
		$month = $request[RegisterEnum::MONTH];
		$day = $request[RegisterEnum::DAY];
		$birthdate = $year . '-' . $month . '-' . $day;
		
		$vo = new User();
		$vo->setLogin($this->db->escape($login));
		$vo->setPassword($this->db->escape($password));
		$vo->setFirstname($this->db->escape($firstname));
		$vo->setLastname($this->db->escape($lastname));
		$vo->setEmail($this->db->escape($email));
		$vo->setOnline(0);
		$vo->setGender($gender);
		$vo->setBirthdate($birthdate);
		$vo->setAvatar(0);
		$vo->setActive(0);
		$vo->setVisitNumber(0);
		$vo->setLastActive(' ');
		
		$dao = $this->dao->getDAO("User");
		return $dao->save($vo);
	}
}

?>