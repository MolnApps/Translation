<?php

class TestCase extends \PHPUnit_Framework_TestCase
{
	protected function pathToFile($filename)
	{
		return $this->pathToData() . '/' . $filename;
	}

	protected function pathToData()
	{
		return realpath(__DIR__ . '/../../../data');
	}

	protected function expectedArray()
	{
		return [
			'signin' => [
				'success' => 'You succesfully signed in',
				'error' => 'Authentication error',
			]
		];
	}
}