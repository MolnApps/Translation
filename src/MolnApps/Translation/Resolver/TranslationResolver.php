<?php

namespace MolnApps\Translation\Resolver;

use \MolnApps\Translation\Resource\Resource;
use \MolnApps\Translation\Translator;

trait TranslationResolver
{
	private $translators = [];

	public function addTranslator($locale, Resource $resource)
	{
		$this->translators[$locale][] = $this->createTranslator($resource);
	}

	private function createTranslator(Resource $resource)
	{
		return Translator::make($resource);
	}

	public function translate($key)
	{
		return $this->callTranslatorMethodWithFallback('translate', [$key]);
	}

	public function translateChoice($key, $count, array $placeholders = [])
	{
		$args = [$key, $count, $placeholders];

		return $this->callTranslatorMethodWithFallback('translateChoice', $args);
	}

	private function callTranslatorMethodWithFallback($methodName, $args)
	{
		return $this->callTranslatorMethod($methodName, $args, $this->getLocale())
			?: $this->callTranslatorMethod($methodName, $args, $this->getFallbackLocale());
	}

	private function callTranslatorMethod($methodName, $args, $locale)
	{
		if ( ! $this->canTranslate($locale)) {
			return;
		}

		foreach ($this->getTranslators($locale) as $translator) {
			$translation = call_user_func_array([$translator, $methodName], $args);

			if ($translation) {
				return $translation;
			}
		}
	}

	private function canTranslate($locale)
	{
		return isset($this->translators[$locale]);
	}

	private function getTranslators($locale)
	{
		return $this->translators[$locale];
	}
}