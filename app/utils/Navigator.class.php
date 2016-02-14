<?php

class Navigator
{
	public static function redirectTo($location = null)
	{
		$location = $location == null ? BASE_URL : BASE_URL . $location;
		header("Location: " . $location);
	}
}

?>