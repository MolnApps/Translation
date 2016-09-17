<?php

namespace MolnApps\Translation\Resource;

class PhpFileResourceTest extends \TestCase
{
	/** @test */
	public function it_can_be_instantiated()
	{
		$res = PhpFileResource::make();

		$this->assertNotNull($res);
	}

	/** @test */
	public function it_implements_resource_interface()
	{
		$res = PhpFileResource::make();

		$this->assertInstanceOf(Resource::class, $res);
	}

	/** @test */
	public function it_returns_empty_array_by_default()
	{
		$res = PhpFileResource::make();

		$this->assertEquals([], $res->toArray());
	}

	/** @test */
	public function it_returns_array()
	{
		$res = PhpFileResource::make($this->pathToFile('resource.php'));

		$this->assertEquals($this->expectedArray(), $res->toArray());
	}
}