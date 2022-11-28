<?php

namespace src\Controller;

use src\Attribute\IsLogged;
use src\Repository\Users;
use libs\Attribute\Route;
use src\Entity\Account;
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

	#[Route('madoff.user.new', '/admin/user/new', 'GET')]
	public function new_form(array &$request) {
		$this->page('account-new.php');
	}

	#[Route('madoff.account.new', '/admin/account/new', 'POST')]
	public function new(array &$request) {
		/** @var Users */
		$acc_repo = $this->db->repo(Users::class);
		$user = new Account;
		$user->email = $request['data']['_email'];
		switch ($request['data']['_role']) {
			case '0':
				$user->role = 'admin';
				break;
			case '1':
				$user->role = 'executive';
				break;
			case '2':
				$user->role = 'client';
				break;
		}
		$user->phone = $request['data']['_phone'];
		$user->person_id = intval($request['data']['_person_id']);
		if (empty($request['data']['_password']))
			throw new Message('Contraseña vacia', 'Se debe de tener una contraseña con lo menos 1 caracter');
		$user->password = password_hash($request['data']['_password'], PASSWORD_BCRYPT);
		$acc_repo->newUser($user);
		redirect('/home');
	}

	#[Route('madoff.user.edit', '/admin/user/edit', 'GET')]
	public function edit_form(array &$request) {
		/** @var Users */
		$acc_repo = $this->db->repo(Users::class);
		$this->page('account-edit.php', [ 'user' => $acc_repo->getById($request['params']['id'] ?? 0) ]);
	}

	#[Route('madoff.account.edit', '/admin/account/edit', 'POST')]
	public function edit(array &$request) {
		/** @var Users */
		$acc_repo = $this->db->repo(Users::class);
		$user = $acc_repo->getById($request['data']['_id'] ?? 0);
		if (!empty($request['data']['_email'] ?? null))
			$user->email = $request['data']['_email'];
		if (!empty($request['data']['_role'] ?? null)) {
			switch ($request['data']['_role']) {
				case '0':
					$user->role = 'admin';
					break;
				case '1':
					$user->role = 'executive';
					break;
				case '2':
					$user->role = 'client';
					break;
			}
		}
		if (!empty($request['data']['_phone'] ?? null))
			$user->phone = $request['data']['_phone'];
		if (!empty($request['data']['_person_id'] ?? null))
			$user->person_id = intval($request['data']['_person_id']);
		if (!empty($request['data']['_password']))
			$user->password = password_hash($request['data']['_password'], PASSWORD_BCRYPT);
		$acc_repo->updateUser($user);
		redirect('/home');
	}

	#[Route('madoff.account.edit', '/admin/account/edit', 'POST')]
	public function remove_form(array &$request) {
		$this->page('account-new.php');
	}
}
