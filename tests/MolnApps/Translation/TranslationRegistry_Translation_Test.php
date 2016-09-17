<?php

namespace MolnApps\Translation;

class TranslationRegistryTest extends \TestCase
{
	/** @test */
	public function it_registers_a_translator()
	{
		$registry = new TranslationRegistry;

		$resource = ResourceFactory::makeArray([
			'welcome' => 'Welcome to the app!'
		]);

		$registry->addTranslator('en_US', $resource);

		$this->assertEquals('Welcome to the app!', $registry->translate('welcome'));
	}

	/** @test */
	public function it_registers_multiple_translators()
	{
		$registry = new TranslationRegistry;

		$resource1 = ResourceFactory::makeArray([
			'welcome' => 'Welcome to the app!'
		]);

		$resource2 = ResourceFactory::makeArray([
			'signin' => [
				'success' => 'You successfully signed in',
				'error' => 'Authentication error',
			]
		]);

		$registry->addTranslator('en_US', $resource1);
		$registry->addTranslator('en_US', $resource2);

		$this->assertEquals('Welcome to the app!', $registry->translate('welcome'));
		$this->assertEquals('You successfully signed in', $registry->translate('signin.success'));
	}

	/** @test */
	public function it_uses_fallback_translator_if_a_match_is_found()
	{
		$registry = new TranslationRegistry;

		$registry->setLocale('it_IT');

		$resource1 = ResourceFactory::makeArray([
			'welcome' => 'Welcome to the app!',
			'goodbye' => 'Goodbye from the app!'
		]);

		$resource2 = ResourceFactory::makeArray([
			'welcome' => 'Benvenuti alla app!'
		]);

		$registry->addTranslator('en_US', $resource1);
		$registry->addTranslator('it_IT', $resource2);

		$this->assertEquals('Benvenuti alla app!', $registry->translate('welcome'));
		$this->assertEquals('Goodbye from the app!', $registry->translate('goodbye'));
	}

	/** @test */
	public function it_handles_plurals_and_fallback_if_needed()
	{
		$registry = new TranslationRegistry;

		$registry->setLocale('it_IT');

		$fallbackResource = ResourceFactory::makeArray([
			'apple' => 'I found an apple|I found many apples',
			'orange' => 'I found an orange|I found many oranges',
		]);

		$resource = ResourceFactory::makeArray([
			'apple' => 'Ho trovato una mela|Ho trovato molte mele'
		]);

		$registry->addTranslator('en_US', $fallbackResource);
		$registry->addTranslator('it_IT', $resource);

		$this->assertEquals('Ho trovato una mela', $registry->translateChoice('apple', 1));
		$this->assertEquals('Ho trovato molte mele', $registry->translateChoice('apple', 2));

		$this->assertEquals('I found an orange', $registry->translateChoice('orange', 1));
		$this->assertEquals('I found many oranges', $registry->translateChoice('orange', 2));
	}
}