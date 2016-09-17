<?php

namespace MolnApps\Translation\Resource;

class YamlFileResourceTest extends \TestCase
{
	/** @test */
	public function it_can_be_instantiated()
	{
		$res = YamlFileResource::make();

		$this->assertNotNull($res);
	}

	/** @test */
	public function it_implements_resource_interface()
	{
		$res = YamlFileResource::make();

		$this->assertInstanceOf(Resource::class, $res);
	}

	/** @test */
	public function it_returns_empty_array_by_default()
	{
		$res = YamlFileResource::make();

		$this->assertEquals([], $res->toArray());
	}

	/** @test */
	public function it_returns_array()
	{
		$res = YamlFileResource::make($this->pathToFile('resource.yaml'));

		$this->assertEquals($this->expectedArray(), $res->toArray());
	}
}