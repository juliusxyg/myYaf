<?php

class ShowCategoryController extends Yaf\Controller_Abstract 
{
  public function listAction() 
  {
   		
    
  }

  public function editAction() 
  {
    if($this->getRequest()->isPost())
    {
      $name = $this->getRequest()->getPost("name","");
      $id = $this->getRequest()->getPost("id","");
      $em = Yaf\Registry::get("entityManager");

      if($id)
      {
      	$showcategory = $em->find('Entity\ShowCategory', $id);
      }

      if($name)
      {
      	if(!$showcategory)
      	{
      		$showcategory = new Entity\ShowCategory();
      	}
      	$showcategory->setName($name);
      	$showcategory->setTotalShows(0);
      	$em->persist($showcategory);
      	$em->flush();
      }
        
    }

  }

}
?>
