<?php

namespace MolnApps\Translation;

use \MolnApps\Translation\Resource\Resource;

use \MolnApps\Translation\Resolver\LocaleResolver;
use \MolnApps\Translation\Resolver\PathResolver;
use \MolnApps\Translation\Resolver\TranslationResolver;

class TranslationRegistry
{
	use LocaleResolver;
	use PathResolver;
	use TranslationResolver;

	public function __construct()
	{
		$this->setLocale('en_US');
		$this->setFallbackLocale('en_US');
	}
}