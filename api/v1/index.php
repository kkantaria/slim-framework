<?php
date_default_timezone_set('Asia/Kolkata');
require '../vendor/autoload.php';
require 'src/config/settings.php';
require 'src/config/constant.php';
require 'src/config/general.php';
require 'src/helper/site_helpers.php';
require 'src/helper/file_helpers.php';
$app = new \Slim\App($config);
require 'src/config/container.php';
foreach (glob("../lib/*.php") as $filename) include $filename;
require 'src/models/model.users.php';
require 'src/config/middleware.php';
@include('src/route/'.get_route().'.route.php');

spl_autoload_register(function ($classname) 
{
	if(file_exists(__DIR__ . '/src/classes/class.'.strtolower($classname). '.php'))
	{
		require_once __DIR__ . '/src/classes/class.'.strtolower($classname). '.php';
	}
	
});

$app->run();