<?php

/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf\Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */

class Bootstrap extends Yaf\Bootstrap_Abstract
{

  public function _initConfig()
  {
    $config = Yaf\Application::app()->getConfig();
    Yaf\Registry::set("config", $config);
  }

  public function _initDoctrine(Yaf\Dispatcher $dispatcher)
  {
  	$config = Yaf\Registry::get("config");

  	//yaf的默认机制只用自己的autoload，会出现redeclare的问题， 所以放到library下了，唉
  	$doctrineLoader = new Doctrine\Common\ClassLoader('Entity', $config->get('application')->library);
		$doctrineLoader->register();
		$doctrineLoader = new Doctrine\Common\ClassLoader('Entity\Proxy', $config->get('application')->library);
		$doctrineLoader->register();

  	if($config->get('application')->environment == "dev")
  	{
  		$cache = new \Doctrine\Common\Cache\ArrayCache;
  	}else{
  		$cache = new \Doctrine\Common\Cache\ApcCache;
  	}

  	$doctrineConfig = new Doctrine\ORM\Configuration();
		$doctrineConfig->setMetadataCacheImpl($cache);
		$driverImpl = $doctrineConfig->newDefaultAnnotationDriver($config->get('doctrine')->entity_path);
		$doctrineConfig->setMetadataDriverImpl($driverImpl);
		$doctrineConfig->setQueryCacheImpl($cache);
		$doctrineConfig->setProxyDir($config->get('doctrine')->proxy_path);
		$doctrineConfig->setProxyNamespace('Entity\Proxy');

		if($config->get('application')->environment == "dev") 
		{
	    $doctrineConfig->setAutoGenerateProxyClasses(true);
		}else{
	    $doctrineConfig->setAutoGenerateProxyClasses(false);
		}

		$connectionParams = array(
	    'dbname' => $config->get('database')->connection->dbname,
	    'user' => $config->get('database')->connection->user,
	    'password' => $config->get('database')->connection->password,
	    'host' => $config->get('database')->connection->host,
	    'port' => $config->get('database')->connection->port,
	    'charset' => $config->get('database')->connection->charset,
	    'driver' => $config->get('database')->connection->driver,
		);

		$em = Doctrine\ORM\EntityManager::create($connectionParams, $doctrineConfig);
		Yaf\Registry::set("entityManager", $em);
  }
}