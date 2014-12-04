<?php
namespace Service;

class Chain
{
	private $_aspects = array();
	private $context;
	private $result;
	private $index;

	public function __construct($container, $name, $params)
	{
		$this->loadAspects($container, $name);
		$this->context = new Context($params);
		$this->result = new Result();
		$this->index = 0;
	}

	public function walk()
	{
		$ir = $this->index++;
		if($ir < count($this->_aspects))
		{
			$this->_aspects[$ir]->run($this);
		}
	}

	protected function loadAspects($container, $name)
	{
		$object = new $container;
		$this->_aspects = call_user_func_array(array($object, $name), array());
	}

	public function getContext()
	{
		return $this->context;
	}

	public function getResult()
	{
		return $this->result;
	}
}