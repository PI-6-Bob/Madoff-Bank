<?php

namespace src\Controller;

use App;
use libs\Attribute\Route;
use src\Service\Test;

class Index 
{
	public function __construct(App $app) {
	}

	#[Route('madoff.index', '/', 'GET')]
	public function cont(App $app, array $request) {
		page('index.html');
	}
}
