<?php

class IndexController extends Yaf\Controller_Abstract 
{
   public function indexAction() 
   {//默认Action
   		
    $this->getView()->assign("content", "Hello World");

    
  }

  public function apiAction() 
  {
  	if(1 || $this->getRequest()->isPost())
    {
    	$game = $this->getRequest()->getPost("game","dota2");
    	$start = $this->getRequest()->getPost("start","0");
    	$num = $this->getRequest()->getPost("num","10");

    	if(!$game || !is_numeric($start) || !is_numeric($num))
    	{
    		$this->getResponse()->setBody(json_encode(array("error"=>0, "result"=>array())));
    	}else{

	    	$em = Yaf\Registry::get("entityManager");
		    $query = $em->createQuery('SELECT a.title, a.game, a.source, a.vurl FROM Entity\LiveVideoRun a WHERE a.game = \''.$game.'\' ORDER BY a.weight DESC')->setMaxResults($num)->setFirstResult($start);
		    $res = $query->getResult();
	    	$this->getResponse()->setBody(json_encode(array("error"=>0, "result"=>$res)));
	    }
    }

    Yaf\DisPatcher::getInstance()->disableView();
  }
}
?>
