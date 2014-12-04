<?php
namespace Service;

/**
* array
*/
class Context extends ParamHolder
{
	public function __construct($inputs = '')
	{
		if(is_array($inputs))
		{
			$this->_parameters = $inputs;
		}
	}

}