<?php
namespace Service;

/**
*	a Service can contain many chains
* For example, for video, there can be search_video, create_video, delete_video, and each contains different or shared aspects
* Just like Module->Actions
*/
class Chain
{
	private $_aspects = array();
	private $context;
	private $result;
	private $index;

	/**
	 *	$container|string			service class name
	 *  $name|string 					the chain method name in the service class
	 *  $params|array 				inputs of the chain
	 */
	public function __construct($container, $name, Array $params)
	{
		$this->loadAspects($container, $name);
		$this->context = new Context($params);
		$this->result = new Result();
		$this->index = 0;
	}

	/**
	 *	step into the aspects of the chain, and execute its process method
	 */
	public function walk()
	{
		$ir = $this->index++;
		if($ir < count($this->_aspects))
		{
			$this->_aspects[$ir]->run($this);
		}
	}

	/**
	 *	load the aspects of the chain
	 *
	 *	$container|string			service class name
	 *  $name|string 					the chain method name in the service class
	 */
	protected function loadAspects($container, $name)
	{
		$object = new $container;
		$this->_aspects = call_user_func_array(array($object, $name), array());
	}

	/* execute context of the chain*/
	public function getContext()
	{
		return $this->context;
	}
	/* execute result of the chain*/
	public function getResult()
	{
		return $this->result;
	}
}