<?php

class Arrays
{
	public static function toString($array)
	{
		foreach ($array as $value)
		{
			$string .= $value; 
		}
		return $string;
	}
	
	public static function toStringSQL($array, $separator = null)
	{
		$string = '';
		foreach ($array as $value)
		{
			$string .= $value;
			if (next($array) != null) $string .= $separator;
		}
		return $string;
	}
}

?>