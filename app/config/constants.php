<?php

// base path locally on server
define ('BASE_PATH', getcwd() . '/');

// base url of the LOCAL application
define ('BASE_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/simland/');

// base url of the SERVER application
//define ('BASE_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/');

define ('PATH_IMG', 'images/');

define ('URL_IMG', BASE_URL . 'images/');
//define ('URL_IMG', 'http://static.simland.pl/');

define ('PATH_PHOTOS', PATH_IMG . 'photos/');
define ('URL_PHOTOS', URL_IMG . 'photos/');

define ('PATH_PHOTOS_FULL', PATH_PHOTOS . 'full/');
define ('URL_PHOTOS_FULL', URL_PHOTOS . 'full/');

define ('PATH_PHOTOS_THUMB', PATH_PHOTOS . 'thumb/');
define ('URL_PHOTOS_THUMB', URL_PHOTOS . 'thumb/');

define ('URL_PROFILE', BASE_URL . 'profile/');
define ('URL_GALLERY', BASE_URL . 'gallery/');
define ('URL_LOGIN', BASE_URL . 'login/');
define ('PATH_TEMPLATES', BASE_PATH . 'templates/');

define ('PATH_MESSAGES', BASE_PATH . 'resources/');

define ('URL_IMG_ICONS', URL_IMG . 'icons/');

define ('URL_CSS', BASE_URL . 'css/');
define ('URL_JS', BASE_URL . 'js/');

// set of extentions
define ('BASE_EXT', '.');
define ('EXT_PNG', BASE_EXT . 'png');
define ('EXT_GIF', BASE_EXT . 'gif');
define ('EXT_JPG', BASE_EXT . 'jpg');
define ('EXT_HTML', BASE_EXT . 'html');
define ('EXT_PROPS', BASE_EXT . 'properties');

?>