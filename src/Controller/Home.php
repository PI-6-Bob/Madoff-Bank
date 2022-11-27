<?php

namespace src\Controller;

use Controller;
use libs\Attribute\Route;
use src\Attribute\Logged;

#[Logged]
class Home extends Controller
{
	#[Route('madoff.home', '/home')]
	public function content() {
		$this->page('home.php');
	}
}
