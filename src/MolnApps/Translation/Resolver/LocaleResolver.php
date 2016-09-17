<?php

namespace MolnApps\Translation\Resolver;

trait LocaleResolver
{
	private $locale;
	private $fallbackLocale;

	public function setLocale($locale)
	{
		if ($this->validateLocale($locale)) {
			$this->locale = $locale;
		}

		return $this;
	}

	public function getLocale()
	{
		return $this->locale;
	}

	public function setFallbackLocale($fallbackLocale)
	{
		if ($this->validateLocale($fallbackLocale)) {
			$this->fallbackLocale = $fallbackLocale;
		}

		return $this;
	}

	public function getFallbackLocale()
	{
		return $this->fallbackLocale;
	}

	private function validateLocale($locale)
	{
		return preg_match('/^[a-z]{2}_[A-Z]{2}$/', $locale);
	}
}