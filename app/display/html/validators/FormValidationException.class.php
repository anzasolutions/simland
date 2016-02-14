<?php

/**
 * Thrown on form validation failure.
 * @author anza
 */
class FormValidationException extends Exception
{
	private $failedInput;
	
	public function FormValidationException($failedInput)
	{
		$this->failedInput = $failedInput;
	}
	
	public function getFailedInput()
	{
		return $this->failedInput;
	}
	
	public function setFailedInput($failedInput)
	{
		$this->failedInput = $failedInput;
	}
}

?>