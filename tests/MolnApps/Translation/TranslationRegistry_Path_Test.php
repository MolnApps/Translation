<?php

namespace MolnApps\Translation;

class TranslationRegistryPathTest extends \TestCase
{
	/** @test */
	public function it_returns_null_if_file_path_does_not_exists()
	{
		$registry = new TranslationRegistry;

		$path = $registry->getFilePath($this->pathToFile('{locale}/view.php'));

		$this->assertEquals(null, $path);
	}

	/** @test */
	public function it_returns_an_existing_file_path()
	{
		$registry = new TranslationRegistry;

		$registry->setLocale('it_IT');

		$path = $registry->getFilePath($this->pathToFile('views/{locale}/view.php'));

		$this->assertEquals($this->pathToFile('views/it_IT/view.php'), $path);
	}

	/** @test */
	public function it_returns_a_fallback_locale_file_path()
	{
		$registry = new TranslationRegistry;

		$registry->setLocale('it_IT');

		$path = $registry->getFilePath($this->pathToFile('views/{locale}/hello.php'));

		$this->assertEquals($this->pathToFile('views/en_US/hello.php'), $path);
	}
}