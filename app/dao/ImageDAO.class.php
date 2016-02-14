<?php

/**
 * Manipulates Image object in database.
 * 
 * @author anza
 * @since 2010-04-11
 */
class ImageDAO extends DAO
{
	public function findById($id)
	{
		$sql = "SELECT id, number, album, filename, userid, main, description, added
				FROM image
				WHERE id = '{$id}'
				LIMIT 0, 1";
		
		$images = $this->execute($sql);
		
		if (count($images) > 0)
		{
			return $images[0];
		}
	}
	
	public function findLatest($number)
	{
		$sql = "SELECT id, number, album, filename, userid, main, description, added
				FROM image
				ORDER BY added
				DESC
				LIMIT 0, {$number}";
		
		$images = $this->execute($sql);
		
//		if (count($images) > 0)
//		{
//			return $images[0];
//		}
//		
//		$users = $this->execute($sql);
		return $result = sizeof($images) > 0 ? $images : null;
	}
	
	public function countByUserId($userid)
	{
		$sql = "SELECT * 
				FROM image
				WHERE userid = '{$userid}'";
		
		$images = $this->execute($sql);
		$imagesNumber = count($images);
		
		return $imagesNumber;
	}
	
	public function countLatestNumber($userid)
	{
		$sql = "SELECT number 
				FROM image
				WHERE userid = '{$userid}'
				ORDER BY number
				DESC
				LIMIT 0, 1";
		
		$images = $this->execute($sql);
//		$imageNo = 
		
		return $result = sizeof($images) > 0 ? $images[0]->getNumber() : null;
		
//		return $image;
	}
	
	public function findByUserIdAndAlbum($userid, $albumNo)
	{
		$sql = "SELECT id, number, album, filename, userid, main, description, added
				FROM image
				WHERE userid = '{$userid}'
				AND album = '{$albumNo}'
				ORDER BY number
				DESC";
		
		$images = $this->execute($sql);
		
		if (count($images) > 0)
		{
			return $images;
		}
	}
	
	public function findByUserIdAndNumber($userid, $number)
	{
		$sql = "SELECT id, number, album, filename, userid, main, description, added
				FROM image
				WHERE userid = '{$userid}'
				AND number = '{$number}'
				ORDER BY number
				DESC
				LIMIT 0, 1";
		
		$images = $this->execute($sql);
		
		if (count($images) > 0)
		{
			return $images[0];
		}
	}
	
	public function findByUserId($userid)
	{
		$sql = "SELECT id, number, album, filename, userid, main, description, added
				FROM image
				WHERE userid = '{$userid}'
				ORDER BY number
				DESC";
		
		$images = $this->execute($sql);
		
		if (count($images) > 0)
		{
			return $images;
		}
	}
	
	public function countByUserIdAndAlbum($userid, $album)
	{
		$sql = "SELECT * 
				FROM image
				WHERE userid = '{$userid}'
				AND album = '{$album}'";
		
		$images = $this->execute($sql);
		$imagesNumber = count($images);
		
		return $imagesNumber;
	}
	
	/* (non-PHPdoc)
	 * @see app/dao/DAO#save($vo)
	 */
	public function save($image)
	{
		if ($image->getId() != '')
		{
			$currentImage = $this->findById($image->getId());
		}
		
		if (count($currentImage) > 0)
		{
			$sql = "UPDATE image SET 
				   	number = '{$image->getNumber()}', 
				   	album = '{$image->getAlbum()}', 
				   	filename = '{$image->getFilename()}', 
				   	userid = '{$image->getUserId()}', 
				   	main = '{$image->getMain()}', 
				   	description = '{$image->getDescription()}', 
				   	added = '{$image->getAdded()}'
				   	WHERE id = '{$image->getId()}'";
		}
		else
		{
			$sql = "INSERT INTO image (number, album, filename, userid, main, description, added)
					VALUES ('{$image->getNumber()}', 
							'{$image->getAlbum()}', 
							'{$image->getFilename()}', 
							'{$image->getUserId()}', 
							'{$image->getMain()}', 
							'{$image->getDescription()}', 
							'{$image->getAdded()}')";
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