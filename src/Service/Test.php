<?php

namespace src\Service;


use libs\Attribute\Service;
use App;

#[Service('test')]
class Test
{
	public function __construct(App $app) {

	}

	public function getH() {
		return 'Hola';
	}
}
