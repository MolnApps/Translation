<?php

namespace MolnApps\Translation\Helper;

use \MolnApps\Translation\Resource\Resource;

class ResourceHelper
{
	private $resource;
	private $resourceArray = [];

	public function __construct(Resource $resource)
	{
		$this->resource = $resource;
	}

	public function find($key)
	{
		return $this->getNestedKey($this->getResourceArray(), $key);
	}

	private function getNestedKey($context, $name) {
		$pieces = explode('.', $name);
	    
	    foreach ($pieces as $piece) {
	        if ( ! is_array($context) || ! array_key_exists($piece, $context)) {
	            return null;
	        }

	        $context = $context[$piece];
	    }

	    return $context;
	}

	private function getResourceArray()
	{
		if ( ! $this->resourceArray) {
			$this->resourceArray = $this->resource->toArray();
		}

		return $this->resourceArray;
	}
}