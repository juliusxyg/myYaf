<?php
define("APP_PATH",  realpath(dirname(__FILE__))); /* root */

require_once APP_PATH . "/vendor/autoload.php";

$app  = new Yaf\Application(APP_PATH . "/conf/application.ini");
$app->bootstrap()->execute(function(){return true;});

$application = new Symfony\Component\Console\Application();
/*Load commands*/
$commandFiles = glob(Yaf\Registry::get("config")->get('application')->library . '/Command/*Command.php');
foreach($commandFiles as $commandFile)
{
	$commandName = 'Command\\'.basename($commandFile, '.php');
	$application->add(new $commandName);
}

$application->run();