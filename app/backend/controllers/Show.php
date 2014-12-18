<?php

class ShowController extends Yaf\Controller_Abstract 
{
  public function listAction() 
  {
   		
    
  }

  public function editAction() 
  {
    $em = Yaf\Registry::get("entityManager");

		//
    $id = $this->getRequest()->get("id","");
  	if($id)
  	{
  		$show = $em->find('Entity\Show', $id);
  	}else{
  		$this->getView()->assign("die_error", "该栏目不存在");
  	}
		
		//
		$query = $em->createQuery('SELECT a.id, a.name, a.totalShows FROM Entity\ShowCategory a');
    try{
	    $categories = $query->getResult();
	  }catch(Exception $e){
	  	echo $e->getMessage();
	  } 

	  $this->getView()->assign("categories", $categories);

	  //
	  if($this->getRequest()->isPost())
    {
    	if(!$show)
    	{
    		$show = new Entity\Show();
    	}

      $name = trim($this->getRequest()->getPost("name",""));
      if($name)
      {
      	$show->setName($name);
      }else{
      	$this->getView()->assign("form_error_name", "名称不能为空");
      }

      $categoryid = trim($this->getRequest()->getPost("category",""));
      if($categoryid)
      {
      	$showcategory = $em->find('Entity\ShowCategory', $categoryid);
      	if($showcategory)
      	{
      		$show->setShowCategory($showcategory);
      	}else{
      		$this->getView()->assign("form_error_category", "分类不存在");
      	}
      }else{
      	$this->getView()->assign("form_error_category", "分类不能为空");
      }

      $story = trim($this->getRequest()->getPost("story",""));
      if($story)
      {
      	$show->setStory($story);
      }else{
      	$this->getView()->assign("form_error_story", "故事不能为空");
      }

      $cover = trim($this->getRequest()->getPost("cover",""));
      if($cover)
      {
      	$show->setCoverImage($cover);
      }else{
      	$this->getView()->assign("form_error_cover", "封面不能为空");
      }

      $end = trim($this->getRequest()->getPost("end",""));
      if($end)
      {
      	$show->setIsEnd(1);
      }else{
      	$show->setIsEnd(0);
      }

      $tv = trim($this->getRequest()->getPost("tv",""));
      if($tv)
      {
      	$show->setIsTv(1);
      }else{
      	$show->setIsTv(0);
      }

      if($tv)
      {
	      $tvseason = trim($this->getRequest()->getPost("tvseason",""));
	      if($tvseason)
	      {
	      	$show->setSeason($tvseason);
	      }else{
	      	$show->setSeason(1);
	      }

	      $tvrelease = trim($this->getRequest()->getPost("tvrelease",""));
	      if($tvrelease)
	      {
	      	$show->setReleaseFrom($tvrelease);
	      }else{
	      	$this->getView()->assign("form_error_tvrelease", "不能为空");
	      }

	      $tvday = trim($this->getRequest()->getPost("tvday",""));
	      if($tvday)
	      {
	      	$show->setTvDay($tvday);
	      }else{
	      	$this->getView()->assign("form_error_tvday", "不能为空");
	      }

	      $tvnumber = trim($this->getRequest()->getPost("tvnumber",""));
	      if($tvnumber)
	      {
	      	$show->setTvNumber($tvnumber);
	      }else{
	      	$this->getView()->assign("form_error_tvnumber", "不能为空");
	      }
	    }else{
	    	$show->setSeason(0);
	    	$show->setReleaseFrom("");
	    	$show->setTvDay(0);
	    	$show->setTvNumber(0);
	    }

	    $ova = trim($this->getRequest()->getPost("ova",""));
      if($ova)
      {
      	$show->setIsOva(1);
      }else{
      	$show->setIsOva(0);
      }

      if($ova)
      {
	      $ovanumber = trim($this->getRequest()->getPost("ovanumber",""));
	      if($ovanumber)
	      {
	      	$show->setOvaNumber($ovanumber);
	      }else{
	      	$this->getView()->assign("form_error_ovanumber", "不能为空");
	      }
	    }else{
	    	$show->setOvaNumber(0);
	    }
        
    }

    if($show)
    {
    	$this->getView()->assign("name", $show->getName());
    }
  }

}
?>
