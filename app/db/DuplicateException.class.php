<?php

/**
 * Inform about attempyt to insert dupliacted value to database.
 * Should be thrown when database insert might be duplicated.
 * 
 * @author anza
 */
class DuplicateException extends Exception
{
	private $error;
	private $field;
	
	public function DuplicateException($error)
	{
		$this->error = $error;
		$this->extractField();
	}
	
	/**
	 * Extract value from array generated by mysqli_error.
	 * 
	 * @return void
	 */
	public function extractField()
	{
		$extracted = explode('key ', $this->error);
		$field = str_replace('\'', '', $extracted[1]);
		$this->field = $field;
	}
	
	public function getField()
	{
		return $this->field;
	}
	
	public function setField($field)
	{
		$this->field = $field;
	}
}

?>