<?php

class Album
{
	private $id = null;
	private $number = null;
	private $userId = null;
	private $access = null;
	private $description = null;
	private $title = null;
	private $icon = null;
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

	public function getUserId()
	{
		return $this->userId;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	public function getAccess()
	{
		return $this->access;
	}

	public function setAccess($access)
	{
		$this->access = $access;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getIcon()
	{
		return $this->icon;
	}

	public function setIcon($icon)
	{
		$this->icon = $icon;
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