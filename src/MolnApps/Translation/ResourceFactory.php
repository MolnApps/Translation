<?php

namespace MolnApps\Translation;

use \MolnApps\Translation\Resource\ArrayResource;
use \MolnApps\Translation\Resource\PhpFileResource;
use \MolnApps\Translation\Resource\YamlFileResource;
use \MolnApps\Translation\Resource\YamlResource;

class ResourceFactory
{
	public static function makeArray(array $array)
	{
		return ArrayResource::make($array);
	}

	public static function makeYaml($yaml)
	{
		return YamlResource::make($yaml);
	}

	public static function makePhpFile($path)
	{
		return PhpFileResource::make($path);
	}

	public static function makeYamlFile($path)
	{
		return YamlFileResource::make($path);
	}
}