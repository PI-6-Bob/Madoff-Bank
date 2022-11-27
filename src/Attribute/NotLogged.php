<?php

namespace src\Attribute;

use Attribute;

#[Attribute]
class NotLogged
{
	public array $roles = [];

	public function __construct(string ...$roles) {
		$this->roles = $roles;
	}

	public function validate(?string $role) {
		if (empty($this->roles))
			return true;
		return in_array($role, $this->roles);
	}
}
