<?php

namespace MolnApps\Translation;

use \MolnApps\Translation\Resource\ArrayResource;
use \MolnApps\Translation\Resource\PhpFileResource;
use \MolnApps\Translation\Resource\YamlFileResource;
use \MolnApps\Translation\Resource\YamlResource;

class ResourceFactoryTest extends \TestCase
{
	/** @test */
	public function it_creates_a_array_resource()
	{
		$resource = ResourceFactory::makeArray([
			'hello' => 'Hello world',
		]);

		$this->assertInstanceOf(ArrayResource::class, $resource);
	}

	/** @test */
	public function it_creates_a_php_resource_from_file()
	{
		$resource = ResourceFactory::makePhpFile($this->pathToFile('resources.php'));

		$this->assertInstanceOf(PhpFileResource::class, $resource);
	}

	/** @test */
	public function it_creates_a_yaml_resource()
	{
		$resource = ResourceFactory::makeYaml('hello:'."\r\n".'  Hello world');

		$this->assertInstanceOf(YamlResource::class, $resource);
	}

	/** @test */
	public function it_creates_a_yaml_resource_from_file()
	{
		$resource = ResourceFactory::makeYamlFile($this->pathToFile('resources.yaml'));

		$this->assertInstanceOf(YamlFileResource::class, $resource);
	}
}