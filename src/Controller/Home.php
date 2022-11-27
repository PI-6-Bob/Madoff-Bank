<?php

namespace src\Controller;

use Controller;
use libs\Attribute\Route;
use src\Attribute\IsLogged;

#[IsLogged]
class Home extends Controller
{
	#[Route('madoff.home', '/home')]
	public function content() {
		$this->page('home.php');
	}

	#[Route('madoff.logout', '/logout')]
	public function logout() {
		$this->session->stop();
		redirect('/');
	}
}
