<?php

namespace src\Controller;

use Controller;
use Exception;
use libs\Attribute\Route;
use src\Attribute\IsLogged;

#[IsLogged]
class Home extends Controller
{
	#[Route('madoff.home', '/home')]
	public function content() {
		$this->page('home.php', [
			'title' => 'Banca digital'
		]);
	}

	#[Route('madoff.logout', '/logout')]
	public function logout() {
		$this->session->stop();
		redirect('/');
	}
}
