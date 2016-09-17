<?php

namespace MolnApps\Translation\Resource;

class YamlResourceTest extends \TestCase
{
	/** @test */
	public function it_can_be_instantiated()
	{
		$res = YamlResource::make();

		$this->assertNotNull($res);
	}

	/** @test */
	public function it_implements_resource_interface()
	{
		$res = YamlResource::make();

		$this->assertInstanceOf(Resource::class, $res);
	}

	/** @test */
	public function it_returns_empty_array_by_default()
	{
		$res = YamlResource::make();

		$this->assertEquals([], $res->toArray());
	}

	/** @test */
	public function it_returns_array()
	{
		$yaml = 'signin:
  success: You succesfully signed in
  error: Authentication error';

		$res = YamlResource::make($yaml);

		$this->assertEquals($this->expectedArray(), $res->toArray());
	}
}