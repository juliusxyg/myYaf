<?php
namespace Video;

class DoSearchAspect extends \Service\Aspect
{
	public function process(\Service\Context $context, \Service\Result $result)
	{
		$result->set("do_search","1");
	}
}