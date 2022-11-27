<?php

namespace src\Attribute;

use Attribute;

#[Attribute]
class Logged
{
	public function __construct(public ?string $role = null) {
	}
}
