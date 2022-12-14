<?php

namespace src\Repository;

use Repository;
use src\Entity\Account;
use src\Entity\Person;

class Users extends Repository
{
	public function deleteUser(Account $account) {
		$stmt = $this->prepare('DELETE FROM account WHERE id=?');
		$stmt->bind_param('i', $account->id);
		$stmt->execute();
		$stmt->close();
	}

	public function newUser(Account $account): int {
		$stmt = $this->prepare('INSERT INTO account(email, phone, password, person_id, role) VALUES (?, ?, ?, ?, ?)');
		$stmt->bind_param('sssis', 
			$account->email, 
			$account->phone,
			$account->password, 
			$account->person_id, 
			$account->role
		);
		$stmt->execute();
		$account->id = $stmt->insert_id;
		$stmt->close();
		return $account->id;
	}

	public function updateUser(Account $user) {
		$stmt = $this->prepare('UPDATE account SET email=?, phone=?, password=?, person_id=?, role=?, status=? WHERE id=?');
		$stmt->bind_param('sssisii',
			$user->email,
			$user->phone,
			$user->password,
			$user->person_id,
			$user->role,
			$user->status,
			$user->id
		);
		$stmt->execute();
		$stmt->close();
	}

	public function getByEmail(string $email): ?Account {
		$stmt = $this->prepare('SELECT * FROM account WHERE email=?');
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$res = $stmt->get_result();
		$ret = $res->fetch_object(Account::class);
		$res->close();
		$stmt->close();
		return $ret;
	}

	public function getById(int $id): ?Account {
		$stmt = $this->prepare('SELECT * FROM account WHERE id=?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$res = $stmt->get_result();
		$ret = $res->fetch_object(Account::class);
		$res->close();
		$stmt->close();
		return $ret;
	}

	public function getPerson(Account $account): ?Person {
		$stmt = $this->prepare('SELECT * FROM person WHERE id=?');
		$stmt->bind_param('i', $account->person_id);
		$stmt->execute();
		$res = $stmt->get_result();
		$ret = $res->fetch_object(Person::class);
		$res->close();
		$stmt->close();
		return $ret;
	}

	public function getClients(int $account_id, int $limit, int $page = 0): array {
		$offset = $page > 0? $page * $limit : 0;
		$stmt = $this->prepare('SELECT a.* FROM account a JOIN client c ON a.id = c.account_id WHERE a.role = "client" AND c.executive_id  = (SELECT e.id FROM executive e WHERE e.account_id = ?) LIMIT ?, ?');
		$stmt->bind_param('iii', $account_id, $offset, $limit);
		$stmt->execute();
		$res = $stmt->get_result();
		$ret = [];
		while ($loan = $res->fetch_object(Account::class)) 
			$ret[] = $loan;
		$res->close();
		$stmt->close();
		return $ret;
	}

	public function getUsers(int $limit, int $page = 0): array {
		$offset = $page > 0? $page * $limit : 0;
		$stmt = $this->prepare('SELECT * FROM account LIMIT ?, ?');
		$stmt->bind_param('ii', $offset, $limit);
		$stmt->execute();
		$res = $stmt->get_result();
		$ret = [];
		while ($loan = $res->fetch_object(Account::class)) 
			$ret[] = $loan;
		$res->close();
		$stmt->close();
		return $ret;
	}
}
