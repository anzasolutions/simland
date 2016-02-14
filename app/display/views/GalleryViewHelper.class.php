<?php

class GalleryViewHelper extends ViewHelper
{
	public function getExistingAlbumsToForm()
	{
		$albums = $this->model->getExistingAlbums();
		$output .= $this->html->selectBegin('choose_album', 'select', '', 'choose_album');
		
		if ($albums == 0)
		{
			$output .= $this->html->optionBegin('', 'option', '', 0) . 'Album glowny' . $this->html->optionEnd();
		}
		else
		{
			foreach ($albums as $album)
			{
				$output .= $this->html->optionBegin('', 'option', '', $album->getNumber()) . $album->getTitle() . $this->html->optionEnd();
			}
		}
		
		$output .= $this->html->selectEnd();
		return $output;
	}
	
	public function getAlbumForShowcase()
	{
		$userId = $_SESSION['oUserProfile']->getId();
		$albums = $this->model->getExistingAlbums();
		
		$output = '';
		foreach ($albums as $album)
		{
			$initialDivStyle = 'photo_frame';
			if ($album->getIcon() == null)
			{
				$initialDivStyle = 'photo_frame2';
			}
			$output .= $this->html->divBegin('', $initialDivStyle);
			$output .= $this->html->spanClosed();
			$output .= $this->html->linkBegin(URL_GALLERY . $userId . '/' . $album->getNumber());
			$output .= $this->html->imageBegin(URL_PHOTOS . $userId . '/thumbs/' . $album->getIcon()) . $this->html->imageEnd();
			$output .= $this->html->linkEnd();
			$output .= $this->html->divBegin('', 'credits');
			$output .= $this->html->linkBegin(URL_GALLERY . $userId . '/' . $album->getNumber());
			$output .= $album->getTitle();
			$output .= $this->html->linkEnd();
			$output .= $this->html->divBegin('', 'photo_frame_date') . $album->getAdded() . ' | ' . $this->model->countInAlbum($album->getNumber()) . ' fotek';
			$output .= $this->html->divEnd();
			$output .= $this->html->divEnd();
			$output .= $this->html->divEnd();
		}
		
		return $output;
	}
	
	public function getPhotosForShowcase($albumNo)
	{
		$userId = $_SESSION['oUserProfile']->getId();
		$images = $this->model->getPhotosPerUserAndAlbum($albumNo);
		
		$output = '';
		foreach ($images as $image)
		{
			$output .= $this->html->divBegin('', 'photo_frame3');
			$output .= $this->html->spanClosed();
			$output .= $this->html->linkBegin(URL_GALLERY . $userId . '/' . $albumNo . '/' . $image->getNumber());
			$output .= $this->html->imageBegin(URL_PHOTOS . $userId . '/thumbs/' . $image->getFilename()) . $this->html->imageEnd();
			$output .= $this->html->linkEnd();
			$output .= $this->html->divBegin('', 'credits');
			$output .= $this->html->divBegin('', 'photo_info');
			$output .= $this->html->divBegin('', 'photo_info_bold') . 'Data dodania:';
			$output .= $this->html->divEnd() . Date::convert($image->getAdded(), 'd.m.Y H:i');
			$output .= $this->html->divEnd();
			$output .= $this->html->divBegin('', 'photo_info');
			$output .= $this->html->divBegin('', 'photo_info_bold') . 'Opis:';
			$output .= $this->html->divEnd() . $image->getDescription();
			$output .= $this->html->divEnd();
			$output .= $this->html->divEnd();
			$output .= $this->html->divEnd();
		}
		
		return $output;
	}
	
	public function getSinglePhoto($photoNo)
	{
		$userId = $_SESSION['oUserProfile']->getId();
//		$images = $this->model->getSinglePhoto($photoNo);
		$image = $this->model->getSinglePhoto($photoNo);
		
//		if (sizeof($images) == 0)
		if ($image == null)
		{
			$this->request->container[ErrorEnum::ERROR] = ErrorEnum::ERROR;
			$output = $this->getAlbumForShowcase();
//			print_r($this->request->container);
//			Navigator::redirectTo('gallery/');
//			die ('404 Not Found');
			return $output;
		}
		
//		foreach ($images as $image)
//		{
		$output = '';
			$output .= $this->html->divBegin('', 'photo_full_size');
			$output .= $this->html->imageBegin(URL_PHOTOS . $userId . '/full/' . $image->getFilename()) . $this->html->imageEnd();
			$output .= $this->html->divEnd();
//		}
		
		return $output;
	}
	
	public function getSingleAlbumName($albumNo)
	{
		$userId = $_SESSION['oUserProfile']->getId();
		$album = $this->model->getSingleAlbumName($albumNo);
		
		$output = '';
		$output .= $this->html->linkBegin(URL_GALLERY . $userId . '/' . $albumNo . '/');
		$output .= $album->getTitle();
		$output .= $this->html->linkEnd();
		
		return $output;
	}
	
	public function getNext($albumNo, $photoNo)
	{
		$userId = $_SESSION['oUserProfile']->getId();
		$next = $this->model->getNextPhoto($photoNo, $albumNo);

		$output = '';
		if ($next != null)
		{
			$output .= $this->html->spanBegin('', '', 'margin: 0 0 0 20px;');
			$output .= $this->html->linkBegin(URL_GALLERY . $userId . '/' . $albumNo . '/' . $next->getNumber());
			$output .= 'następne';
			$output .= $this->html->linkEnd();
			$output .= $this->html->spanEnd();
		}
		
		return $output;
	}
	
	public function getPrevious($albumNo, $photoNo)
	{
		$userId = $_SESSION['oUserProfile']->getId();
		$previous = $this->model->getPreviousPhoto($photoNo, $albumNo);
		
		$output = '';
		if ($previous != null)
		{
			$output .= $this->html->linkBegin(URL_GALLERY . $userId . '/' . $albumNo . '/' . $previous->getNumber());
			$output .= 'poprzednie';
			$output .= $this->html->linkEnd();
		}
		
		return $output;
	}
	
	public function countInAlbums()
	{
		
	}
}

?>