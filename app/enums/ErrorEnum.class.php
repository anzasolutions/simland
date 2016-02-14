<?php

abstract class ErrorEnum extends Enum
{
	const ERROR = 'error';
	const VALIDATION = 'errorValidation';
	const USER = 'errorUser';
	const LOGIN = 'errorLogin';
	const EMAIL = 'errorEmail';
	const STYLE_SUFFIX = '_error_style';
	const STYLE_COLOR = 'color: #A62A2E;';
	const USER_INCORRECT = 'errorUserIncorrect';
	const FILENOIMAGE = 'errorFileNoImage';
}

?>