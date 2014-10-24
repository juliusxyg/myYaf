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
		if($this->index < count($this->_aspects))
		{
			$this->_aspects[$this->index]->run($this);
			$this->index++;
		}
	}

	protected function loadAspects($container, $name)
	{
		$object = new $container;
		$this->_aspects = call_user_func_array(array($object, $name));
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