<?php

namespace MolnApps\Translation;

class TranslationRegistryLocaleTest extends \TestCase
{
	/** @test */
	public function it_sets_default_locale_and_fallback_locale_to_en_US()
	{
		$registry = new TranslationRegistry;

		$this->assertEquals('en_US', $registry->getLocale());
		$this->assertEquals('en_US', $registry->getFallbackLocale());
	}

	/** @test */
	public function it_sets_a_locale()
	{
		$registry = new TranslationRegistry;

		$registry->setLocale('it_IT');
		
		$this->assertEquals('it_IT', $registry->getLocale());
	}

	/** @test */
	public function it_sets_a_fallback_locale()
	{
		$registry = new TranslationRegistry;

		$registry->setFallbackLocale('it_IT');
		
		$this->assertEquals('it_IT', $registry->getFallbackLocale());
	}

	/** @test */
	public function it_wont_accept_invalid_locale()
	{
		$registry = new TranslationRegistry;

		$registry->setLocale('it');
		$registry->setFallbackLocale('it');
		
		$this->assertEquals('en_US', $registry->getLocale());
		$this->assertEquals('en_US', $registry->getFallbackLocale());
	}
}