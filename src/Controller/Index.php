<?php

namespace src\Controller;

use Controller;
use libs\Attribute\Route;
use src\Attribute\NotLogged;
use src\Repository\Users;

#[NotLogged]
class Index extends Controller
{
	#[Route('madoff.index', '/')]
	public function content(array &$request) {
		$this->page('index.php', [
			'title' => 'Inicio',
			'_target' => $request['params']['_target'] ?? '/home',
		]);
	}

	#[Route('madoff.about', '/about')]
	public function about() {
		$this->page('about.html', [
			'title' => 'Acerca de nosotros',
		]);
	}

	#[Route('madoff.tems', '/policy')]
	public function terms() {
		$this->page('terms.html', [
			'title' => 'Politica',
		]);
	}

	#[Route('madoff.login', '/login', 'post')]
	public function login(array &$request) {
		/** @var Users */
		$repo = $this->db->repo(Users::class);
		$user = $repo->getByEmail($request['data']['_email']);
		if (isset($user) && password_verify($request['data']['_password'], $user->password)) {
			$this->session->set('uid', $user->id);
			$this->session->set('role', $user->role);
			$this->session->set('email', $user->email);
			$this->session->set('person_id', $user->person_id);
			$this->session->set('balance', $user->balance);
			header("Location: {$request['data']['_target']}");
		}
		header("Location: {$request['headers']['Referer']}");
	}
}
