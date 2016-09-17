<?php

namespace MolnApps\Translation;

use \MolnApps\Translation\Resource\Resource;

use \MolnApps\Translation\Helper\PlaceholderHelper;
use \MolnApps\Translation\Helper\ResourceHelper;

class Translator
{
	private $resource;
	private $placeholder;
	
	private function __construct(Resource $resource)
	{
		$this->resource = new ResourceHelper($resource);
		$this->placeholder = new PlaceholderHelper;
	}

	public static function make($resource)
	{
		if ( ! $resource instanceof Resource) {
			$resource = ResourceFactory::makeArray($resource);
		}

		return new static($resource);
	}

	public function translate($key, array $placeholders = [])
	{
		return $this->translateChoice($key, null, $placeholders);
	}

	public function translateChoice($key, $count, array $placeholders = [])
	{
		$choice = $this->getChoice($this->resource->find($key), $count);

		$placeholders = $this->placeholder->addCount($placeholders, $count);
		
		return $this->placeholder->replace($choice, $placeholders);
	}

	// ! Translation methods

	private function getChoice($translation, $count)
	{
		list ($zero, $one, $many) = $this->normalizeChoices($translation);

		if (is_null($count)) {
			return $many;
		}

		if ($count == 0) {
			return $zero;
		}

		if ($count == 1) {
			return $one;
		}

		return $many;
	}

	private function normalizeChoices($translation)
	{
		$choices = explode('|', $translation);

		if (count($choices) == 1) {
			return [$choices[0], $choices[0], $choices[0]];
		}
			
		if (count($choices) == 2) {
			return [$choices[1], $choices[0], $choices[1]];
		}

		return $choices;
	}
}