<?php

class IndexController extends Yaf\Controller_Abstract 
{
  public function indexAction() 
   {//默认Action
   		
    $this->getView()->assign("content", "I am backend");

  }

  public function loginAction() 
  {//默认Action
   	if($this->getRequest()->isPost())
    {
      $username = $this->getRequest()->getPost("username","");
      $password = $this->getRequest()->getPost("password","");
      if($username == Yaf\Registry::get("config")->get("admin")->name && 
         $password == Yaf\Registry::get("config")->get("admin")->passwd)
      {
        Yaf\Session::getInstance()->set("Authentication", true);
      }else{
        Yaf\Session::getInstance()->set("Authentication", false);
      }
    }

    $this->getView()->assign("content", "I am backend login");
    Yaf\Registry::get("layout")->setTemplate("layoutGuest.pthml");
    
  }
}
?>
