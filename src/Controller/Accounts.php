<?php

namespace src\Controller;

use src\Repository\Persons;
use src\Attribute\IsLogged;
use src\Repository\Users;
use libs\Attribute\Route;
use Controller;
use Message;

#[IsLogged('admin')]
class Accounts extends Controller
{

	#[Route('madoff.user.account', '/admin/user')]
	public function account(array &$request) {
		/** @var Users */
		$user_repo = $this->db->repo(Users::class);
		$user = $user_repo->getById($request['params']['id'] ?? 0);
		if (!isset($user))
			throw new Message('Usuario no existe', 'El usuario que especifico no existe');
		/** @var Persons */
		$person_repo = $this->db->repo(Persons::class);
		$this->page('admin-user.php', [
			'user' => $user,
			'person' => $person_repo->getById($user->person_id),
		]);
	}
}
