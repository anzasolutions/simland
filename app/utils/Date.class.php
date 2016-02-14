<?php

class Date
{
	public function Date()
	{
	}
	
	public static function getNow()
	{
		$format = 'Y-m-d H:i:s';
		$date = new DateTime();
		return $date->format($format);
	}
	
	public static function convert($date, $format = null)
	{
		if ($format == null)
		{
			$format = 'Y-m-d H:i:s';
		}
		
		$date = new DateTime($date);
		return $date->format($format);
	}
}

?>