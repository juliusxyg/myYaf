<?php
/**
 * this config is for doctrine cli , run with: php vendor/bin/doctrine orm:generate-entities --help
 */

define("APP_PATH",  realpath(dirname(__FILE__))."/../../"); /* root */

require_once APP_PATH . "/vendor/autoload.php";

$app  = new Yaf\Application(APP_PATH . "/conf/frontend.ini");
$app->bootstrap()->execute(function(){return true;});