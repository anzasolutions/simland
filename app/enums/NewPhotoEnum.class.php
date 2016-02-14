<?php

class NewPhotoEnum extends Enum
{
//	const FILE = 'gallery_file';
	const CHOOSE = 'choose_album';
	const NEW_ALBUM = 'gallery_new_album';
	const DESCRIPTION = 'gallery_desc';
	const MAIN = 'gallery_main';
	const MINI = 'gallery_mini';
	const FORM_SENT = 'form_sent';
	const ALBUM_PUBLIC = 0;
	const ALBUM_PRIVATE = 1;
	
	private $choose;
	private $description;
	private $main;
	private $mini;
	private $newAlbum;
	
	public function NewPhotoEnum($request)
	{
		$this->setChoose($request[self::CHOOSE]);
		$this->setDescription($request[self::DESCRIPTION]);
		$this->setMain($request[self::MAIN]);
		$this->setMini($request[self::MINI]);
		$this->setNewAlbum($request[self::NEW_ALBUM]);
	}
	
	public function getChoose()
	{
		return $this->choose;
	}

	public function setChoose($choose)
	{
		$this->choose = $choose;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getMain()
	{
		return $this->main;
	}

	public function setMain($main)
	{
		$this->main = $main;
	}

	public function getMini()
	{
		return $this->mini;
	}

	public function setMini($mini)
	{
		$this->mini = $mini;
	}

	public function getNewAlbum()
	{
		return $this->newAlbum;
	}

	public function setNewAlbum($newAlbum)
	{
		$this->newAlbum = $newAlbum;
	}
}

?>