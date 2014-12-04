<?php
namespace Service;

/**
* the true process parts of a chain from a service to be executed
* For example, a video service provides a serach_video chain which processes validate_name and do_search aspects
*/
abstract class Aspect
{
	/* user code should be applied here */
	abstract public function process(Context $context, Result $result);

	/* method for chain walk */
	public function run(Chain $chain)
	{
		$this->process($chain->getContext(), $chain->getResult());

		$chain->walk();
	}
}