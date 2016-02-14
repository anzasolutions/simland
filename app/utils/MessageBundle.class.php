<?php

abstract class MessageBundle
{
	public static function getMessage($key)
	{
		$messages = file(PATH_MESSAGES . 'messages' . EXT_PROPS, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$keys = array();
		$values = array();
		
		foreach ($messages as $value)
		{
			$row = explode(' = ', $value);
			array_push($keys, $row[0]);
			array_push($values, $row[1]);
		}
		
		$messages2 = array_combine($keys, $values);
		
		if (array_key_exists($key, $messages2))
		{
			return $messages2[$key];
		}
	}
}

?>