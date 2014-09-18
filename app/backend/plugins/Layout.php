<?php

class LayoutPlugin extends Yaf\Plugin_Abstract
{
	private $_layoutDir;
  private $_layoutFile;
  private $_layoutVars =array();

  public function __construct($layoutFile=null, $layoutDir=null)
  {
    $this->_layoutFile = $layoutFile ? $layoutFile : Yaf\Registry::get("config")->get('template')->default;
    $this->_layoutDir = $layoutDir ? $layoutDir : Yaf\Registry::get("config")->get('application')->layout;
  }

  public function __set($name, $value)
  {
    $this->_layoutVars[$name] = $value;
  }

  public function dispatchLoopShutdown ( Yaf\Request_Abstract $request, Yaf\Response_Abstract $response )
  {
  }

  public function dispatchLoopStartup ( Yaf\Request_Abstract $request, Yaf\Response_Abstract $response )
  {
  }

  public function postDispatch ( Yaf\Request_Abstract $request , Yaf\Response_Abstract $response )
  {
      $body = $response->getBody();

      $response->clearBody();

      $layout = new Yaf\View\Simple($this->_layoutDir);
      $layout->content = $body;
      $layout->base_url = '';
      $layout->assign('layout', $this->_layoutVars);

      $response->setBody($layout->render($this->_layoutFile));
  }

  public function setTemplate( $layoutFile )
  {
  	$this->_layoutFile = $layoutFile;
  }
  
  public function preDispatch ( \Yaf\Request_Abstract $request, \Yaf\Response_Abstract $response )
  {
  }

  public function preResponse ( \Yaf\Request_Abstract $request, \Yaf\Response_Abstract $response )
  {
  }

  public function routerShutdown ( \Yaf\Request_Abstract $request, \Yaf\Response_Abstract $response )
  {
  }

  public function routerStartup ( \Yaf\Request_Abstract $request, \Yaf\Response_Abstract $response )
  {
  }
}