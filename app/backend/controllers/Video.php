<?php

class VideoController extends Yaf\Controller_Abstract 
{

  public function sortAction() 
  {//默认Action
    if(!Yaf\Session::getInstance()->get("Authentication"))
    {
      $this->redirect("/admin.php/login");
    }
    
   	$em = Yaf\Registry::get("entityManager");
    $query = $em->createQuery('SELECT a.id, a.title, a.game, a.source, a.vurl, b.weight FROM Entity\LiveVideo a LEFT JOIN Entity\LiveVideoSort b WITH a.hash = b.hash ORDER BY b.weight DESC');
    $results = $query->getResult();

    Yaf\Registry::get("layout")->setTemplate("layoutGuest.pthml");
    $this->getView()->assign("results", $results);
    
  }

  public function weightAction()
  {
    if($this->getRequest()->isPost())
    {
      $vid = $this->getRequest()->getPost("vid","");
      $weight = $this->getRequest()->getPost("weight","");
      
      $em = Yaf\Registry::get("entityManager");
      $video = $em->find('Entity\LiveVideo', $vid);
      if($video)
      {
        if($video->getSort())
        {
          $video->getSort()->setWeight($weight);
        }else{
          $videoSort = new Entity\LiveVideoSort();
          $videoSort->setHash($video->getHash());
          $videoSort->setWeight($weight);
          $em->persist($videoSort);
        }

        $em->flush();
      }
      $videorun = $em->find('Entity\LiveVideoRun', $vid);
      if($videorun)
      {
        $videorun->setWeight($weight);
        $em->flush();
      }
    }
    Yaf\Registry::get("layout")->setTemplate(false);
    $this->getResponse()->setBody(json_encode(array("err"=>0)));
    return false;
  }
}

