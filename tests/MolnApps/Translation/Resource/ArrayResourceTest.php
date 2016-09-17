<?php

namespace MolnApps\Translation\Resource;

class ArrayResourceTest extends \TestCase
{
	/** @test */
	public function it_can_be_instantiated()
	{
		$res = ArrayResource::make();

		$this->assertNotNull($res);
	}

	/** @test */
	public function it_implements_resource_interface()
	{
		$res = ArrayResource::make();

		$this->assertInstanceOf(Resource::class, $res);
	}

	/** @test */
	public function it_returns_empty_array_by_default()
	{
		$res = ArrayResource::make();

		$this->assertEquals([], $res->toArray());
	}

	/** @test */
	public function it_returns_array()
	{
		$arr = [
			'signin' => [
				'success' => 'You succesfully signed in',
				'error' => 'Authentication error',
			]
		];
		
		$res = ArrayResource::make($arr);

		$this->assertEquals($this->expectedArray(), $res->toArray());
	}
}