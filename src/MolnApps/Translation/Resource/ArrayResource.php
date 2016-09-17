<?php

namespace MolnApps\Translation\Resource;

class ArrayResource implements Resource
{
	private $array = [];

	private function __construct(array $array)
	{
		$this->array = $array;
	}
	
	public static function make(array $array = [])
	{
		return new static($array);
	}

	public function toArray()
	{
		return $this->array;
	}
}