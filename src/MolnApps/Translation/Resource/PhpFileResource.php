<?php

namespace MolnApps\Translation\Resource;

class PhpFileResource extends AbstractFileResource
{
	public function convertToArray()
	{
		return include($this->getPath());
	}
}