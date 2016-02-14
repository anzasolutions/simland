<?php

// all necessary settings are included
include('app/config/init.php');

// class autoloading is started
Autoloader::init();

// application registry initializes
$registry = new Registry();

// core components loading
$registry->session = Session::getInstance();
$registry->db = MySQLDriver::getInstance();
$registry->request = RequestHandler::getInstance();
$registry->dao = new DAOFactory($registry);
$registry->router = Router::getInstance($registry);
$registry->template = new Template($registry);

// application is started
$registry->router->loader();

?>