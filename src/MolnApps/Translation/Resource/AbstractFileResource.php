<?php

namespace MolnApps\Translation\Resource;

abstract class AbstractFileResource implements Resource
{
	private $path;

	private $resourceArray;

	private function __construct($path)
	{
		$this->path = $path;
	}
	
	public static function make($path = null)
	{
		return new static($path);
	}

	public function toArray()
	{
		if ( ! $this->path) {
			return [];
		}

		if ( ! $this->resourceArray) {
			$this->resourceArray = $this->convertToArray();
		}

		return $this->resourceArray;
	}

	protected function getPath()
	{
		return $this->path;
	}

	abstract protected function convertToArray();
}