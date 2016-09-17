<?php

namespace MolnApps\Translation\Resource;

class YamlFileResource extends AbstractFileResource
{
	public function convertToArray()
	{
		$yaml = file_get_contents($this->getPath());
		
		return YamlResource::make($yaml)->toArray();
	}
}