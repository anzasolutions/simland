<?php

abstract class Enum
{
	public function constsToArray()
	{
		$enum = new ReflectionClass($this);
		return $enum->getConstants();
	}
}

?>