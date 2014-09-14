<?php

class IndexController extends Yaf_Controller_Abstract 
{
   public function indexAction() 
   {//默认Action
   		
    $this->getView()->assign("content", "Hello World");

    $em = Yaf_Registry::get("entityManager");
  	$video = new Entity\Video;
		$video->setTitle('Mr.Right');
    $video->setUrl("http://");
		$em->persist($video);
		$em->flush();
  }
}
?>
