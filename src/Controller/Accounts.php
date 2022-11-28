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
		$user = $user_repo->getById(intval($request['params']['id'] ?? 0));
		if (!isset($user))
			throw new Message('Usuario no existe', 'El usuario que especifico no existe');
		$this->page('account.php', [ 'user' => $user ]);
	}

	#[Route('madoff.user.edit', '/admin/user/edit', 'GET')]
	public function pre_edit(array &$request) {
		$this->page('account-edit.php', [
		]);
	}

	#[Route('madoff.account.edit', '/admin/user/edit', 'POST')]
	public function edit(array &$request) {
		/** @var Users */
		$user_repo = $this->db->repo(Users::class);
		$user = $user_repo->getById(intval($request['params']['id'] ?? 0));
		if (!isset($user))
			throw new Message('Usuario no existe', 'El usuario que especifico no existe');
		$this->page('account.php', [ 'user' => $user ]);
	}
}
