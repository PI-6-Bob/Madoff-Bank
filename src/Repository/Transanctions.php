<?php

namespace src\Repository;

use Repository;
use src\Entity\Account;
use src\Entity\Transaction;

class Transactions extends Repository
{
	public function deleteTransaction(Transaction $transaction) {
		$stmt = $this->prepare('DELETE FROM transactions WHERE id=?');
		$stmt->bind_param('i', $transaction->id);
		$stmt->execute();
		$stmt->close();
	}

	public function newTransaction(Transaction $transaction): int {
		$stmt = $this->prepare('INSERT INTO transactions(from, to, amount, body, altitude, latitude) VALUES (?, ?, ?, ?, ?, ?)');
		$stmt->bind_param('iidsdd', 
			$transaction->from, 
			$transaction->to,
			$transaction->amount,
			$transaction->body,
			$transaction->altitude,
			$transaction->latitude
		);
		$stmt->execute();
		$transaction->id = $stmt->insert_id;
		$stmt->close();
		return $transaction->id;
	}

	public function updateTransaction(Transaction $transaction) {
		$stmt = $this->prepare('UPDATE transactions SET from=?, to=?, amount=?, body=?, latitude=?, altitude=? WHERE id=?');
		$stmt->bind_param('iidsddi', 
			$transaction->from, 
			$transaction->to,
			$transaction->amount,
			$transaction->body,
			$transaction->latitude,
			$transaction->altitude,
			$transaction->id
		);
		$stmt->execute();
		$stmt->close();
	}

	public function getById(int $id): ?Transaction {
		$stmt = $this->prepare('SELECT * FROM transaction WHERE id=?');
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$res = $stmt->get_result();
		$ret = $res->fetch_object(Transaction::class);
		$res->close();
		$stmt->close();
		return $ret;
	}
}


