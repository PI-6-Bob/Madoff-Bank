<?php

namespace src\Controller;

use Controller;
use Exception;
use libs\Attribute\Route;
use src\Attribute\IsLogged;
use src\Repository\Persons;
use src\Repository\Users;

#[IsLogged]
class Home extends Controller
{
	#[Route('madoff.home', '/home')]
	public function content() {
		$this->page('home.php', [
			'title' => 'Banca digital'
		]);
	}

	#[Route('madoff.home.profile', '/home/profile')]
	public function profile() {
		/** @var Users */
		$user_repo = $this->db->repo(Users::class);
		/** @var Persons */
		$person_repo = $this->db->repo(Persons::class);
		$this->page('profile.php', [
			'user' => $user_repo->getById($this->session->get('uid')),
			'person' => $person_repo->getById($this->session->get('person_id'))
		]);
	}

	#[Route('madoff.logout', '/logout')]
	public function logout() {
		$this->session->stop();
		redirect('/');
	}
}
