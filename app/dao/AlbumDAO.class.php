<?php

/**
 * Manipulates Album object in database.
 * 
 * @author anza
 * @since 2010-04-11
 */
class AlbumDAO extends DAO
{
	public function findAlbumById($id)
	{
		$sql = "SELECT id, number, userid, access, description, title, icon, added
				FROM album
				WHERE id = '{$id}'
				LIMIT 0, 1";
		
		$albums = $this->execute($sql);
		
		if (count($albums) > 0)
		{
			return $albums[0];
		}
	}
	
	public function findAlbumByNumberAndUserId($number, $userid)
	{
		$sql = "SELECT id, number, userid, access, description, title, icon, added
				FROM album
				WHERE number = '{$number}'
				AND userid = '{$userid}'
				LIMIT 0, 1";
		
		$albums = $this->execute($sql);
		
		if (count($albums) > 0)
		{
			return $albums[0];
		}
	}
	
	public function findAlbumByUserId($userid)
	{
		$sql = "SELECT id, number, userid, access, description, title, icon, added
				FROM album
				WHERE userid = '{$userid}'
				ORDER BY number
				DESC";
		
		$albums = $this->execute($sql);
		
		if (count($albums) > 0)
		{
			return $albums;
		}
	}
	
	public function findSingleNameByUserIdAndNumber($userid, $number)
	{
		$sql = "SELECT title
				FROM album
				WHERE number = '{$number}'
				AND userid = '{$userid}'
				LIMIT 0, 1";
		
		$albums = $this->execute($sql);

		if (sizeof($albums) > 0)
		{
			return $albums[0];
		}
	}
	
//	public function findByUserIdAndIcon($userid)
//	{
//		$sql = "SELECT id, number, userid, access, description, title, icon, added
//				FROM album a, image i
//				WHERE a.userid = '{$userid}'
//				AND ";
//		
//		$albums = $this->execute($sql);
//		
//		if (count($albums) > 0)
//		{
//			return $albums;
//		}
//	}
	
	public function countLatestNumber($userid)
	{
		$sql = "SELECT number 
				FROM album
				WHERE userid = '{$userid}'
				ORDER BY number
				DESC
				LIMIT 0, 1";
		
		$albums = $this->execute($sql);
//		$imageNo = 
		
		return $result = sizeof($albums) > 0 ? $albums[0]->getNumber() : null;
		
//		return $image;
	}
	
	public function countByUserId($userid)
	{
		$sql = "SELECT * 
				FROM album
				WHERE userid = '{$userid}'";
		
		$albums = $this->execute($sql);
		$albumsNumber = count($albums);
		
		return $albumsNumber;
	}
	
	/* (non-PHPdoc)
	 * @see app/dao/DAO#save($vo)
	 */
	public function save($album)
	{
		if ($album->getNumber() != '')
		{
//			echo "$album->getNumber() == " . $album->getNumber();
			$currentAlbum = $this->findAlbumByNumberAndUserId($album->getNumber(), $_SESSION['oUser']->getId());
		}
//		echo $album->getIcon();
		if (count($currentAlbum) > 0)
		{
//			echo 'updating...';
			// on update getTitle() gets blank
			$sql = "UPDATE album SET 
				   	number = '{$album->getNumber()}', 
				   	userid = '{$album->getUserId()}', 
				   	access = '{$album->getAccess()}', 
				   	description = '{$album->getDescription()}', 
				   	title = '{$album->getTitle()}', 
				   	icon = '{$album->getIcon()}', 
				   	added = '{$album->getAdded()}'
				   	WHERE userid = '{$album->getUserId()}'
				   	AND	number = '{$album->getNumber()}'";
		}
		else
		{
//			echo 'inserting...';
			
			$sql = "INSERT INTO album (number, userid, access, description, title, icon, added)
					VALUES ('{$album->getNumber()}', 
							'{$album->getUserId()}', 
							'{$album->getAccess()}', 
							'{$album->getDescription()}', 
							'{$album->getTitle()}', 
							'{$album->getIcon()}', 
							'{$album->getAdded()}')";
        }
            
		$this->db->execute($sql);
		$affectedRows = $this->db->connection->affected_rows;
		
		// TODO: replace below with more specific Exception if necessary
		if (mysqli_error($this->db->connection) != null)
		{
			throw new Exception();
		}
		
        return $affectedRows;
	}
	
	//TODO: to be defined
	public function delete($user) {}
}

?>