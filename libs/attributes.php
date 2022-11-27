<?php

namespace libs\Attribute;

use Attribute;

#[Attribute]
class Route 
{
	public string $class;
	public string $fn;

	public function __construct(public string $name, public ?string $path = null, public ?string $method = null) {
		if (isset($method))
			$this->method = strtolower($method);
		if (isset($path)) {
			$xpl_path = explode('/', $path);
			$xpl_path = array_filter($xpl_path, fn($dir) => !empty($dir));
			$this->path = '/' . implode('/', $xpl_path);
		}
	}
}

#[Attribute]
class Service 
{
	public string $class;

	public function __construct(public string $name) {
	}
}

#[Attribute]
class Task
{
	public string $class;
	public string $fn;

	public function __construct(public string $task, public int $weight = 0) {
	}
}

