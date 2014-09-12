<?php
define("APP_PATH",  realpath(dirname(__FILE__) . '/../')); /* 指向public的上一级 */

require_once APP_PATH . "/vendor/autoload.php";

$app  = new Yaf_Application(APP_PATH . "/conf/application.ini");
$app->bootstrap()->run();
