<?php

namespace MolnApps\Translation;

class TranslatorTest extends \PHPUnit_Framework_TestCase
{
	/** @test */
	public function it_returns_null_if_translation_was_not_found()
	{
		$translator = Translator::make([]);

		$this->assertEquals(null, $translator->translate('foo'));
	}

	/** @test */
	public function it_provides_a_translation()
	{
		$translator = Translator::make(['welcome' => 'Welcome']);

		$this->assertEquals('Welcome', $translator->translate('welcome'));
	}

	/** @test */
	public function it_provides_a_nested_translation()
	{
		$translator = Translator::make([
			'signin' => [
				'success' => 'You successfully signed in',
				'error' => 'Authentication error',
			]
		]);

		$this->assertEquals('You successfully signed in', $translator->translate('signin.success'));
	}

	/** @test */
	public function it_replaces_a_placeholder_if_one_is_provided()
	{
		$translator = Translator::make(['welcome' => 'Welcome back %fullName%!']);

		$this->assertEquals(
			'Welcome back John Doe!', 
			$translator->translate('welcome', ['fullName' => 'John Doe'])
		);
	}

	/** @test */
	public function it_handles_plurals()
	{
		$translator = Translator::make(['apple' => 'There is one apple|There are many apples']);

		$this->assertEquals(
			'There are many apples', 
			$translator->translate('apple')
		);

		$this->assertEquals(
			'There is one apple', 
			$translator->translateChoice('apple', 1)
		);

		$this->assertEquals(
			'There are many apples', 
			$translator->translateChoice('apple', 2)
		);
	}

	/** @test */
	public function it_handles_plurals_with_zero_count()
	{
		$translator = Translator::make([
			'apple' => 'There are no apples|There is one apple|There are many apples'
		]);

		$this->assertEquals(
			'There are many apples', 
			$translator->translate('apple')
		);

		$this->assertEquals(
			'There are no apples', 
			$translator->translateChoice('apple', 0)
		);

		$this->assertEquals(
			'There is one apple', 
			$translator->translateChoice('apple', 1)
		);

		$this->assertEquals(
			'There are many apples', 
			$translator->translateChoice('apple', 2)
		);
	}

	/** @test */
	public function it_handles_plurals_with_placeholders()
	{
		$translator = Translator::make(['apple' => 'There is %count% apple|There are %count% apples']);

		$this->assertEquals(
			'There are 0 apples', 
			$translator->translateChoice('apple', 0, ['count' => 0])
		);

		$this->assertEquals(
			'There is 1 apple', 
			$translator->translateChoice('apple', 1, ['count' => 1])
		);

		$this->assertEquals(
			'There are 2 apples', 
			$translator->translateChoice('apple', 2, ['count' => 2])
		);
	}

	/** @test */
	public function it_automatically_creates_a_count_placeholder()
	{
		$translator = Translator::make([
			'apple' => 'There is %count% apple|There are %count% apples'
		]);

		$this->assertEquals(
			'There are %count% apples', 
			$translator->translate('apple')
		);

		$this->assertEquals(
			'There are 0 apples', 
			$translator->translateChoice('apple', 0)
		);

		$this->assertEquals(
			'There is 1 apple', 
			$translator->translateChoice('apple', 1)
		);

		$this->assertEquals(
			'There are 2 apples', 
			$translator->translateChoice('apple', 2)
		);
	}
}