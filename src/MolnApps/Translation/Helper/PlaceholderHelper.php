<?php

namespace MolnApps\Translation\Helper;

class PlaceholderHelper
{
	public function addCount(array $placeholders, $count)
	{
		if (is_null($count)) {
			return $placeholders;
		}

		return array_merge(['count' => $count], $placeholders);
	}

	public function replace($template, array $placeholders)
	{
		$placeholders = $this->normalize($placeholders);

		return str_replace(array_keys($placeholders), array_values($placeholders), $template);
	}

	private function normalize(array $placeholders)
	{
		$result = [];

		foreach ($placeholders as $k => $v) {
			$result['%' . $k . '%'] = $v;
		}

		return $result;
	}
}