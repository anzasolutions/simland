<?php

class Image
{
	private $id = null;
	private $number = null;
	private $album = null;
	private $filename = null;
	private $userId = null;
	private $main = null;
	private $description = null;
	private $added = null;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getNumber()
	{
		return $this->number;
	}

	public function setNumber($number)
	{
		$this->number = $number;
	}

	public function getAlbum()
	{
		return $this->album;
	}

	public function setAlbum($album)
	{
		$this->album = $album;
	}

	public function getFilename()
	{
		return $this->filename;
	}

	public function setFilename($filename)
	{
		$this->filename = $filename;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	public function getMain()
	{
		return $this->main;
	}

	public function setMain($main)
	{
		$this->main = $main;
	}

	public function getDescription()
	{
		if ($this->description == null)
		{
			return "brak opisu!";
		}
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getAdded()
	{
		if ($this->added == null)
		{
			return Date::getNow();
		}
		return $this->added;
	}

	public function setAdded($added)
	{
		$this->added = $added;
	}
}

?>