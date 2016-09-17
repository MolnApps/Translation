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
	public function it_registers_a_translator_and_replaces_placeholders()
	{
		$registry = new TranslationRegistry;

		$resource = ResourceFactory::makeArray([
			'welcome' => 'Welcome to %app%!'
		]);

		$registry->addTranslator('en_US', $resource);

		$this->assertEquals('Welcome to MolnReport!', $registry->translate('welcome', ['app' => 'MolnReport']));
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
			'apple' => 'Ho trovato una mela|Ho trovato molte mele',
			'fruit' => 'Ho trovato una %fruit%|Ho trovato molte %fruit%',
		]);

		$registry->addTranslator('en_US', $fallbackResource);
		$registry->addTranslator('it_IT', $resource);

		$this->assertEquals('Ho trovato una mela', $registry->translateChoice('apple', 1));
		$this->assertEquals('Ho trovato molte mele', $registry->translateChoice('apple', 2));

		$this->assertEquals('I found an orange', $registry->translateChoice('orange', 1));
		$this->assertEquals('I found many oranges', $registry->translateChoice('orange', 2));

		$this->assertEquals(
			'Ho trovato una banana', 
			$registry->translateChoice('fruit', 1, ['fruit' => 'banana'])
		);
	}

	/** @test */
	public function it_enforces_a_locale()
	{
		$registry = new TranslationRegistry;

		$en = ResourceFactory::makeArray([
			'welcome' => 'Welcome to the app!',
			'apple' => 'I found an apple|I found many apples',
		]);

		$it = ResourceFactory::makeArray([
			'welcome' => 'Benvenuti alla app!',
			'apple' => 'Ho trovato una mela|Ho trovato molte mele',
		]);

		$fr = ResourceFactory::makeArray([
			'welcome' => 'Bienvenue sur la app!',
			'apple' => 'J\'ai trouvé une pomme|J\'ai trouvé %count% pommes'
		]);

		$registry->addTranslator('en_US', $en);
		$registry->addTranslator('it_IT', $it);
		$registry->addTranslator('fr_FR', $fr);

		// Default to en_US
		$this->assertEquals('Welcome to the app!', $registry->translate('welcome'));
		$this->assertEquals('I found an apple', $registry->translateChoice('apple', 1));

		// Enforce fr_FR
		$this->assertEquals('Bienvenue sur la app!', $registry->translate('welcome', null, 'fr_FR'));
		$this->assertEquals('J\'ai trouvé une pomme', $registry->translateChoice('apple', 1, null, 'fr_FR'));

		$registry->setLocale('it_IT');

		// Default to it_IT
		$this->assertEquals('Benvenuti alla app!', $registry->translate('welcome'));
		$this->assertEquals('Ho trovato molte mele', $registry->translateChoice('apple', 2));

		// Enforce fr_FR
		$this->assertEquals('Bienvenue sur la app!', $registry->translate('welcome', null, 'fr_FR'));
		$this->assertEquals('J\'ai trouvé 2 pommes', $registry->translateChoice('apple', 2, null, 'fr_FR'));
	}
}