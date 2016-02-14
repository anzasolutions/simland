<?php

/**
 * Registration controller enum.
 * Contains of constants used during registration.
 *
 * @author anza
 * @since 2010-03-21
 */
class RegisterEnum extends AuthEnum
{
	const FIRSTNAME = 'register_firstname';
	const LASTNAME = 'register_lastname';
	const LOGIN = 'register_login';
	const EMAIL = 'register_email';
	const PASSWORD = 'register_password';
	const DAY = 'register_day';
	const MONTH = 'register_month';
	const YEAR = 'register_year';
	const GENDER = 'register_gender';
	const AGREEMENT = 'register_agreement';
//	const PREFIX = 'register_';
	
	/*public static function toArray()
	{
		$enum = new ReflectionClass(__CLASS__);
		return $enum->getConstants();
	}*/
}

?>