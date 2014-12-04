<?php
namespace Service;

/*
* Usage:
* $videoService = new Manager("video_service.yml");
* $videoService->invokeChain("search_video", array('name'=>'lol'));
* $searchResult = $videoService->getResult();
*/

/**
*	Entry of a Service
*/
class Manager
{
	/* chain objec */
	private $chain;
	/* the generated service class name */
	public $containerName;

	/**
	 *	$configPath|string			service yaml file, e.g. sample.yml
	 */
	public function __construct($configPath)
	{
		if(!$this->isConfigParsed($configPath))
		{
			$config = \Symfony\Component\Yaml\Yaml::parse($configPath);
			$this->generateFile($config);
		}
	}

	/**
	 *	$chanName|string			chain name in service yaml file
	 *  $inputs|array 				input parameters of this chain
	 *
	 *  RETURN object|Result
	 */
	public function invokeChain($chainName, Array $inputs = array())
	{
		$this->chain = new Chain($this->containerName, 'get_'.$chainName, $inputs);
		$this->chain->walk();
	}

	/**
	 *  A proxy method
	 *	retrieve current invoked chain context,
	 *  this context mostly is used to get inputs of current chain
	 *
	 *  RETURN object|Context
	 */
	public function getContext()
	{
		return $this->chain->getContext();
	}

	/**
	 *  A proxy method
	 *	retrieve invoked chain's result
	 *
	 *  RETURN object|Context
	 */
	public function getResult()
	{
		return $this->chain->getResult();
	}

	/**
	 *  to check whether the service yaml file is parsed
	 *
	 *  RETURN bool
	 */
	protected function isConfigParsed($filePath)
	{
		$this->containerName = "service_".md5($filePath);
		if(file_exists(APP_PATH.'cache/'.$this->containerName.'.php'))
		{
			require_once(APP_PATH.'cache/'.$this->containerName.".php");
			return true;
		}
		return false;
	}

	/**
	 *  according to the service yaml file, to generate a mapped service class in cache dir
	 *  and include it into runtime environment
	 */
	protected function generateFile($config)
	{
		if(!is_array($config) || !isset($config['Chain']) || !isset($config['Aspect']))
		{
			throw Exception("Invalid config file, please check the sample.yml and follow the rule");
		}

		$content = "
		<?php 
		//{$this->containerName}
		class {$this->containerName}
		{		
			";

		foreach($config['Aspect'] as $aspect_name=>$aspect_class)
		{
			$func = "
			//{$aspect_name}
			public function get_{$aspect_name}()
			{
				return new {$aspect_class['class']}();
			}

			";
			$content .= $func;
		}

		foreach($config['Chain'] as $chain_name=>$chain_aspects)
		{
			$func = "
			//{$chain_name}
			public function get_{$chain_name}()
			{
				return array(
					";
			foreach($chain_aspects as $aspect_class)
			{
				$func .= "\$this->get_{$aspect_class}(), 
				";
			}
				$func .= ");
			}

			";
			$content .= $func;
		}

		$content .= "
		}";

		file_put_contents(APP_PATH.'cache/'.$this->containerName.".php", $content);

		require_once(APP_PATH.'cache/'.$this->containerName.".php");

	}
	


}