<?php

/**
 * Consists of Gallery business logic.
 * Retrieve and manipulate data.
 * 
 * @author anza
 * @since 2010-05-15
 */
class GalleryModel extends Model
{
	/**
	 * Retrieve existing Albums from database.
	 *
	 * @return Album[]
	 * @author anza
	 */
	public function getExistingAlbums()
	{
		$dao = $this->dao->getDAO("Album");
		return $dao->findAlbumByUserId($_SESSION['oUserProfile']->getId());
	}
	
	/**
	 * Retrieve all profile User photos.
	 *
	 * @return Image[]
	 * @author anza
	 */
	public function getPhotosPerUser()
	{
		$dao = $this->dao->getDAO("Image");
		return $dao->findByUserId($_SESSION['oUserProfile']->getId());
	}
	
	/**
	 * Retrieve profile User photos for single Album.
	 *
	 * @return Image[]
	 * @author anza
	 */
	public function getPhotosPerUserAndAlbum($albumNo)
	{
		$dao = $this->dao->getDAO("Image");
		return $dao->findByUserIdAndAlbum($_SESSION['oUserProfile']->getId(), $albumNo);
	}
	
	/**
	 * Retrieve single profile User photo.
	 *
	 * @return Image
	 * @author anza
	 */
	public function getSinglePhoto($photoNo)
	{
		$dao = $this->dao->getDAO("Image");
		return $dao->findByUserIdAndNumber($_SESSION['oUserProfile']->getId(), $photoNo);
	}
	
	public function getPreviousPhoto($photoNo, $albumNo)
	{
		$dao = $this->dao->getDAO("Image");
//		return $dao->findByUserIdAndNumber($_SESSION['oUserProfile']->getId(), --$photoNo);
		$image = $this->getSinglePhoto($photoNo);
		$result = $dao->findByUserIdAndAlbum($_SESSION['oUserProfile']->getId(), $albumNo);
		$currentKey = array_search($image, $result);
		
		$previousKey = --$currentKey;
		return isset($result[$previousKey]) ? $result[$previousKey] : '';
	}
	
	public function getNextPhoto($photoNo, $albumNo)
	{
		$dao = $this->dao->getDAO("Image");
//		return $dao->findByUserIdAndNumber($_SESSION['oUserProfile']->getId(), ++$photoNo);
		$image = $this->getSinglePhoto($photoNo);
		$result = $dao->findByUserIdAndAlbum($_SESSION['oUserProfile']->getId(), $albumNo);
		$currentKey = array_search($image, $result);
		
		$nextKey = ++$currentKey;
		return isset($result[$nextKey]) ? $result[$nextKey] : '';
	}
	
	public function addPhoto($photo, $request)
	{
		$daoAlbum = $this->dao->getDAO("Album");
		
		$albumNumber = $request->getChoose();
		$newAlbumTitle = $request->getNewAlbum();
		
		// TODO: below must be replaced by additional addAlbum method...
		if ($newAlbumTitle != null || $albumNumber == 0)
		{
			$albumNumber = $daoAlbum->countLatestNumber($_SESSION['oUser']->getId());
			++$albumNumber;
			$icon = $request->getMini() ? $photo->getRandomName() : null;
			
			$this->addAlbum($request, $newAlbumTitle, $albumNumber, $icon);
		}
		else if ($request->getMini())
		{
			$album = $daoAlbum->findAlbumByNumberAndUserId($albumNumber, $_SESSION['oUser']->getId());
			$album->setIcon($photo->getRandomName());
			$daoAlbum->save($album);
		}
		
		$daoImage = $this->dao->getDAO("Image");
		$latestImageNo = $daoImage->countLatestNumber($_SESSION['oUser']->getId());
		
		$image = new Image();
		$image->setFilename($photo->getRandomName());
		$image->setAdded($image->getAdded());
		$image->setDescription($request->getDescription());
		$image->setMain($request->getMain());
		$image->setNumber(++$latestImageNo);
		$image->setAlbum($albumNumber);
		$image->setUserId($_SESSION['oUser']->getId());
		
		$imageAdded = $daoImage->save($image);
		
		return $imageAdded;
	}
	
	public function addAlbum($request, $title, $number = null, $mini = null)
	{
		$daoAlbum = $this->dao->getDAO("Album");
		$albumTitle = $title == null ? 'Album glowny' : $title;
		
		if ($number == 0)
		{
			$number = $daoAlbum->countByUserId($_SESSION['oUser']->getId());
			++$number;
		}
		
		if ($mini != null)
		{
			$icon = $mini;
		}
	
		$album = new Album();
		$album->setAccess(NewPhotoEnum::ALBUM_PUBLIC);
		$album->setAdded($album->getAdded());
		$album->setDescription($request->getDescription());
		$album->setNumber($number);
		$album->setTitle($albumTitle);
		$album->setIcon($icon);
		$album->setUserId($_SESSION['oUser']->getId());
		
		$albumAdded = $daoAlbum->save($album);
		
		return $albumAdded;
	}
	
	/**
	 * Retrieve single Album with title from database.
	 *
	 * @param integer $albumNo Album number retrieved from URL action.
	 * @return Album Single object with title found.
	 * @author anza
	 */
	public function getSingleAlbumName($albumNo)
	{
		$dao = $this->dao->getDAO("Album");
		return $dao->findSingleNameByUserIdAndNumber($_SESSION['oUserProfile']->getId(), $albumNo);
	}
	
	public function countInAlbum($albumNo)
	{
		$dao = $this->dao->getDAO("Image");
		return $dao->countByUserIdAndAlbum($_SESSION['oUserProfile']->getId(), $albumNo);
	}
}

?>