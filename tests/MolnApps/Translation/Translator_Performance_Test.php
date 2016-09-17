<?php

namespace MolnApps\Translation;

use \MolnApps\Translation\Resource\Resource;

class TranslatorPerformanceTest extends \PHPUnit_Framework_TestCase
{
	/** @test */
	public function it_wont_load_a_resource_until_it_is_needed()
	{
		$resource = $this->createMock(Resource::class);
		$resource->expects($this->never())->method('toArray');

		$translator = Translator::make($resource);
	}

	/** @test */
	public function it_will_load_a_resource_when_it_is_needed()
	{
		$resource = $this->createMock(Resource::class);
		$resource->expects($this->once())->method('toArray');

		$translator = Translator::make($resource);
		$translator->translate('welcome');
	}
}