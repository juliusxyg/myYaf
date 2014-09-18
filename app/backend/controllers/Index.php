<?php

class IndexController extends Yaf\Controller_Abstract 
{
  public function indexAction() 
   {//默认Action
   		
    $this->getView()->assign("content", "I am backend");

  }

  public function loginAction() 
  {//默认Action
   	
    $this->getView()->assign("content", "I am backend login");
    Yaf\Registry::get("layout")->setTemplate("layoutGuest.pthml");
  }
}
?>
