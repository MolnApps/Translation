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

	public function translate($key, $placeholders = null, $locale = null)
	{
		return $this->callTranslatorMethodWithFallback('translate', [$key, $placeholders], $locale);
	}

	public function translateChoice($key, $count, $placeholders = null, $locale = null)
	{
		$args = [$key, $count, $placeholders];

		return $this->callTranslatorMethodWithFallback('translateChoice', $args, $locale);
	}

	private function callTranslatorMethodWithFallback($methodName, $args, $locale = null)
	{
		$locale = $locale ?: $this->getLocale();

		return $this->callTranslatorMethod($methodName, $args, $locale)
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