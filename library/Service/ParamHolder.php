<?php
namespace Service;

class ParamHolder
{
	public $_parameters = array();

	public function get($name)
	{
		return $this->$name;
	}

	public function set($name, $value)
	{
		$this->$name = $value;
	}

	public function __set($name, $value)
	{
		$this->_parameters[$name] = $value;
	}

	public function __get($name)
	{
		return isset($this->_parameters[$name]) ? $this->_parameters[$name] : null;
	}
}