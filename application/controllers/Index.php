<?php

class IndexController extends Yaf\Controller_Abstract 
{
   public function indexAction() 
   {//默认Action
   		
    $this->getView()->assign("content", "Hello World");
/*
    $em = Yaf\Registry::get("entityManager");
  	$video = new Entity\Video;
		$video->setTitle('Mr.Right');
    $video->setUrl("http://");
		$em->persist($video);
		$em->flush();*/
  }
}
?>
