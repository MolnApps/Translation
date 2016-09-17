<?php

namespace MolnApps\Translation\Resource;

use Symfony\Component\Yaml\Yaml;

class YamlResource implements Resource
{
	private $yaml;

	private function __construct($yaml)
	{
		$this->yaml = $yaml;
	}
	
	public static function make($yaml = '')
	{
		return new static($yaml);
	}

	public function toArray()
	{
		return Yaml::parse($this->yaml) ?: [];
	}
}