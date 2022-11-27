<?php

namespace src\Repository;

use Repository;
use src\Entity\Person;

class Persons extends Repository
{
	public function deletePerson(Person $person) {
		$stmt = $this->prepare('DELETE FROM person WHERE id=?');
		$stmt->bind_param('i', $person->id);
		$stmt->execute();
		$stmt->close();
	}

	public function newPerson(Person $person): int {
		$stmt = $this->prepare('INSERT INTO person(address, birth_date, curp, first_name, last_name, rfc, marital_status) VALUES (?, ?, ?, ?, ?, ?, ?)');
		$stmt->bind_param('sssssss', 
			$person->address, 
			$person->birth_date,
			$person->curp, 
			$person->first_name, 
			$person->last_name,
			$person->rfc,
			$person->marital_status
		);
		$stmt->execute();
		$ret = $stmt->insert_id;
		$stmt->close();
		return $ret;
	}

	public function updatePerson(Person $new) {
		$stmt = $this->prepare('UPDATE person SET address=?, birth_date=?, curp=?, first_name=?, last_name=?, rfc=?, marital_status=?, status=? WHERE id=?');
		$stmt->bind_param('sssisi', 
			$new->address, 
			$new->birth_date,
			$new->curp, 
			$new->first_name, 
			$new->last_name,
			$new->rfc,
			$new->marital_status,
			$new->status,
			$new->id
		);
		$stmt->execute();
		$stmt->close();
	}

	public function getById(int $id): ?Person {
		$stmt = $this->prepare('SELECT * FROM person WHERE id=?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$res = $stmt->get_result();
		$ret = $res->fetch_object(Person::class);
		$res->close();
		$stmt->close();
		return $ret;
	}

	public function getByCurp(string $curp): ?Person {
		$stmt = $this->prepare('SELECT * FROM person WHERE curp=?');
		$stmt->bind_param('s', $curp);
		$stmt->execute();
		$res = $stmt->get_result();
		$ret = $res->fetch_object(Person::class);
		$res->close();
		$stmt->close();
		return $ret;
	}

	public function getByRfc(string $rfc): ?Person {
		$stmt = $this->prepare('SELECT * FROM person WHERE rfc=?');
		$stmt->bind_param('s', $rfc);
		$stmt->execute();
		$res = $stmt->get_result();
		$ret = $res->fetch_object(Person::class);
		$res->close();
		$stmt->close();
		return $ret;
	}
}

