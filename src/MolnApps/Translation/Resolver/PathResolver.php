<?php

namespace MolnApps\Translation\Resolver;

trait PathResolver
{
	public function getFilePath($path)
	{
		return $this->findFilePath($path, $this->getLocale()) 
			?: $this->findFilePath($path, $this->getFallbackLocale());
	}

	private function findFilePath($path, $locale)
	{
		$localizedPath = $this->getLocalizedPath($path, $locale);

		if (file_exists($localizedPath)) {
			return $localizedPath;
		}
	}

	private function getLocalizedPath($path, $locale)
	{
		$placeholders = $this->getPlaceholders($locale);

		return str_replace(array_keys($placeholders), array_values($placeholders), $path);
	}

	private function getPlaceholders($locale)
	{
		return [
			'{locale}' => $locale,
		];
	}
}