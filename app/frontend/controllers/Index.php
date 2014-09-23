<?php

class IndexController extends Yaf\Controller_Abstract 
{
   public function indexAction() 
   {//默认Action
   		
    $this->getView()->assign("content", "Hello World");

    
  }

  public function dyUrlAction()
  {
    $params = $this->getRequest()->getParams();
    $room_id = $params["room_id"];

    $url = 'http://api.douyutv.com/api/client/room/'.$room_id.'/?client_sys=ios';

    $res = $this->mycurl($url, '%E6%96%97%E9%B1%BCTV/1.03 CFNetwork/672.1.15 Darwin/14.0.0');
    $res = json_decode($res, true);
    if ($res['error'] === 0 && is_array($res['data'])) {
      header("User-Agent: %E6%96%97%E9%B1%BCTV/1.03 CFNetwork/672.1.15 Darwin/14.0.0");
      header("Location: ".$res['data']['rtmp_url'].'/'.$res['data']['rtmp_live']);
    }

    return false;
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

    //Yaf\DisPatcher::getInstance()->disableView();
    return false;
  }

  private function mycurl($url, $ua='AppleCoreMedia/1.0.0.11D257 (iPhone; U; CPU OS 7_1_2 like Mac OS X; zh_cn)', $parm='', $timeout=10) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, $ua);
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    if(!empty($parm))
    {
        curl_setopt($curl, CURLOPT_POST, 1 );
        curl_setopt($curl, CURLOPT_POSTFIELDS, (is_array($parm) ? http_build_query($parm) : $parm));
    }
    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }
}
?>
