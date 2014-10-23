<?php 
class SimpleTest extends PHPUnit_Framework_TestCase
{
   
    public function testEqual()
    {
        $a = 1;
        $b = 1;

        $this->assertEquals(2, $b+$a);
    }


    public function testEntityExists()
    {

        // Assert
        $this->assertEquals(true, class_exists("\Entity\LiveVideo"));
    }

    public function testApplicationRuntimeValue()
    {

        // Assert
        $this->assertEquals("dev", \Yaf\Registry::get("config")->get("application")->environment);
    }


}

