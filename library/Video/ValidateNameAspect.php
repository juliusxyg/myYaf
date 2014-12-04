<?php
namespace Video;


class ValidateNameAspect extends \Service\Aspect
{
	public function process(\Service\Context $context, \Service\Result $result)
	{
		$result->set("validate_name",$context->get("name"));
	}
}