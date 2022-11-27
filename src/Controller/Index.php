<?php

namespace src\Controller;

use Controller;
use libs\Attribute\Route;
use src\Repository\User as UserRepo;

class Index extends Controller
{
	#[Route('madoff.index', '/')]
	public function content(array &$request) {
		$this->page('index.php', [
			'_target' => $request['_referer'] ?? '/home',
		]);
	}

	#[Route('madoff.login', '/login', 'post')]
	public function login(array &$request) {
		/** @var UserRepo */
		$repo = $this->db->repo(UserRepo::class);
		$user = $repo->getByEmail($request['data']['_email']);
		if (isset($user) && password_verify($request['data']['_password'], $user->password)) {
			$this->session->set('role', $user->role);
			$this->session->set('email', $user->email);
			$this->session->set('person_id', $user->person_id);
			header("Location: {$request['data']['_target']}");
		}
	}
}
