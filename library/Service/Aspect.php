<?php
namespace Service;

abstract class Aspect
{
	abstract public function process(Context $context, Result $result);

	public function run(Chain $chain)
	{
		$this->process($chain->getContext(), $chain->getResult());

		$chain->walk();
	}
}