<?php

class IndexController extends Yaf\Controller_Abstract 
{
  public function indexAction() 
   {//默认Action
   		
    $this->getView()->assign("content", "I am backend");

  }

  public function loginAction() 
  {//默认Action
    Yaf\Session::getInstance()->set("Authentication", false);
    
   	if($this->getRequest()->isPost())
    {
      $username = $this->getRequest()->getPost("username","");
      $password = $this->getRequest()->getPost("password","");
      if($username == Yaf\Registry::get("config")->get("admin")->name && 
         $password == Yaf\Registry::get("config")->get("admin")->passwd)
      {
        Yaf\Session::getInstance()->set("Authentication", true);
        $this->redirect("/admin.php/video/sort");
      }
    }

    $this->getView()->assign("content", "I am backend login");
    Yaf\Registry::get("layout")->setTemplate("layoutGuest.pthml");
    
  }
}
?>
