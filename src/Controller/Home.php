<?php

namespace src\Controller;

use Controller;
use libs\Attribute\Route;
use src\Attribute\IsLogged;
use src\Repository\Persons;
use src\Repository\Transactions;
use src\Repository\Users;

#[IsLogged]
class Home extends Controller
{
	#[Route('madoff.home', '/home')]
	public function content(array &$request) {
		$data = [ 'title' => 'Banca digital' ];
		/** @var Persons */
		$person_repo = $this->db->repo(Persons::class);
		/** @var Users */
		$user_repo = $this->db->repo(Users::class);

		$data['person'] = $person_repo->getById($this->session->get('person_id'));
		switch ($this->session->get('role')) {
			case 'admin':
				$data['users'] = $user_repo->getUsers(10, $request['params']['p'] ?? 0);
				break;
			case 'client':
				/** @var Transactions */
				$transaction_repo = $this->db->repo(Transactions::class);
				$data['user'] = $user_repo->getById($this->session->get('uid'));
				$data['transactions'] = $transaction_repo->accountTransactions($data['user'], 10, $request['params']['p'] ?? 0);
				break;
			case 'executive':
				$data['clients'] = $user_repo->getClients($this->session->get('uid'));
				break;
		}

		$this->page('home.php', $data);
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
