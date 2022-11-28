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
		$stmt = $this->prepare('UPDATE account SET email=?, phone=?, password=?, person_id=?, role=?, amount=?, status=? WHERE id=?');
		$stmt->bind_param('sssisii',
			$user->email,
			$user->phone,
			$user->password,
			$user->person_id,
			$user->role,
			$user->amount,
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

	public function getUsers(): array {
		$stmt = $this->prepare('SELECT * FROM account');
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
