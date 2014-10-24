<?php 
class ServiceTest extends PHPUnit_Framework_TestCase
{
   
    public function testYamlParse()
    {

        $manager = new \Service\Manager(APP_PATH."/library/Service/sample.yml");
        $manager->invokeChain("search_video", array('name'=>'lol'));

        $this->assertTrue(true);
    }


    

}

