<?php
namespace Service;

/*
* Usage:
* $videoService = new Manager("video_service.yml");
* $videoService->invokeChain("search_video", array('name'=>'lol'));
* $searchResult = $videoService->getResult();
*/

class Manager
{
	private $chain;
	public $containerName;

	public function __construct($configPath)
	{
		if(!$this->isConfigParsed($configPath))
		{
			$config = \Symfony\Component\Yaml\Yaml::parse($configPath);
			$this->generateFile($config);
		}
	}

	public function invokeChain($chainName, Array $inputs = array())
	{
		$this->chain = new Chain($this->containerName, 'get_'.$chainName, $inputs);
		$this->chain->walk();
	}

	public function getContext()
	{
		return $this->chain->context;
	}

	public function getResult()
	{
		return $this->chain->result;
	}

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

	protected function generateFile($config)
	{
		if(!is_array($config) || !isset($config['Chain']) || !isset($config['Aspect']))
		{
			throw Exception("Invalid config file, please check the sample.yml and follow the rule");
		}

		$content = "
		<?php 
		class {$this->containerName}
		{		
			";

		foreach($config['Aspect'] as $aspect_name=>$aspect_class)
		{
			$func = "public function get_{$aspect_name}()
			{
				return new {$aspect_class['class']}();
			}
			";
			$content .= $func;
		}

		foreach($config['Chain'] as $chain_name=>$chain_aspects)
		{
			$func = "public function get_{$chain_name}()
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

		$content .= "}";

		file_put_contents(APP_PATH.'cache/'.$this->containerName.".php", $content);

		require_once(APP_PATH.'cache/'.$this->containerName.".php");

	}
	


}