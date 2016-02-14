<?php

class ConnectionException extends Exception
{
	public function getName()
	{
		$name = get_class($this);
		return $name;
	}
}

?>