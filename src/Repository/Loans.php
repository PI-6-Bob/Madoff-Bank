<?php

namespace src\Repository;

use Repository;
use src\Entity\Account;
use src\Entity\Loan;

class Loans extends Repository
{
	public function deleteLoan(Loan $loan) {
		$stmt = $this->prepare('DELETE FROM loan WHERE id=?');
		$stmt->bind_param('i', $loan->id);
		$stmt->execute();
		$stmt->close();
	}

	public function newLoan(Loan $loan): int {
		$stmt = $this->prepare('INSERT INTO loan(amount, periods, account_id) VALUES (?, ?, ?)');
		$stmt->bind_param('dii', 
			$loan->amount, 
			$loan->periods,
			$loan->account_id
		);
		$stmt->execute();
		$loan->id = $stmt->insert_id;
		$stmt->close();
		return $loan->id;
	}

	public function updateLoan(Loan $loan) {
		$stmt = $this->prepare('UPDATE loan SET periods=?, amount=?, account_id=?, WHERE id=?');
		$stmt->bind_param('idiii', 
			$loan->amount, 
			$loan->periods,
			$loan->account_id,
			$loan->id
		);
		$stmt->execute();
		$stmt->close();
	}

	public function getById(int $id): ?Loan {
		$stmt = $this->prepare('SELECT * FROM loan WHERE id=?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$res = $stmt->get_result();
		$ret = $res->fetch_object(Loan::class);
		$res->close();
		$stmt->close();
		return $ret;
	}

	public function accountLoans(int $account_id): array {
		$stmt = $this->prepare('SELECT *, NOT EXISTS(SELECT 1 FROM debts d WHERE d.loan = l.id AND d.`transaction` IS NULL) AS `status` FROM loan l WHERE l.account_id=?');
		$stmt->bind_param('i', $account_id);
		$stmt->execute();
		$res = $stmt->get_result();
		$ret = [];
		while ($loan = $res->fetch_object(Loan::class)) 
			$ret[] = $loan;
		$res->close();
		$stmt->close();
		return $ret;
	}
}

