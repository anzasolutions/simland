<?php

//TODO: if this will be used as a form validator only maybe it should be renamed to FormValidator?
//TODO: in above scenarion it could extend more generic Validator abstract class or implement very generic Validator interface?
class Validator
{
	public function Validator()
	{
	}
	
	/**
	 * Checks whether provided array has any empty value.
	 * 
	 * @param array $values Array of values to be checked.
	 * @return boolean True if any empty value found in array.
	 */
	public function hasEmptyValues($array)
	{
		foreach ($array as $value)
		{
			if (empty($value))
			{
				return true;
			}
		}
	}
	
	/**
	 * Validate elements of given array.
	 * 
	 * @param array $userInputs Form elements with validation rules.
	 * @return boolean True on successful validation.
	 */
	public function userInputs($userInputs)
	{
		//TODO: the rules could be much better
		$rules = array('email' => '^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$^',
						//below line must be improved to not accept special characters like \ / " ' 
					   'name' => '^[A-Za-z0-9_]*$^',
					   'text' => '/^[a-zA-Z0-9_]{3,16}$/',
					   'password' => '/^[a-zA-Z0-9_]{3,16}$/');
//					   'password' => '^[-A-Za-z0-9_]*$');
		
		foreach ($userInputs as $key => $input)
		{
			foreach ($input as $value => $rule)
			{
				$rule = array_key_exists($rule, $rules) ? $rules[$rule] : '';
				
				if (count(explode(' ', $value)) > 1 || $value == '' || $rule == '' || !preg_match($rule, $value))
				{
					throw new FormValidationException($key);
				}
			}
		}
		
		return true;
	}
	
}

?>