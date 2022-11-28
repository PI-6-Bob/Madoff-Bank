<?php

namespace src\Controller;

use src\Attribute\IsLogged;
use src\Repository\Users;
use libs\Attribute\Route;
use src\Entity\Account;
use Controller;
use Exception;
use Message;
use src\Entity\Transaction;
use src\Repository\Loans;
use src\Repository\Transactions;

#[IsLogged('client')]
class Client extends Controller
{
	#[Route('madoff.client.transaction', '/home/transaction', 'get')]
	public function transaction(array &$request) {
		$this->page('transaction.php', [
			'title' => 'Transaccion',
			'_scripts' => [ 'transaction.js' ]
		]);
	}

	#[Route('madoff.client.do_transaction', '/home/transaction/do', 'post')]
	public function do_transaction(array &$request) {
		try {
			/** @var Transactions */
			$trans_repo = $this->db->repo(Transactions::class);
			$transaction = new Transaction;
			$transaction->latitude = floatval($request['data']['_latitude'] ?? 0);
			$transaction->altitude = floatval($request['data']['_altitude'] ?? 0);
			$transaction->to = $request['data']['_account'] ?? null;
			$transaction->from = $this->session->get('uid');
			$transaction->amount = $request['data']['_amount'] ?? null;
			$transaction->body = $request['data']['_body'] ?? null;
			$trans_repo->doTransaction($transaction);
			redirect('/home');
		} catch (Exception $e) {
			throw new Message('No se pudo hacer la transaccion', 'Verifique los datos que inserto');
		};
	}

	#[Route('madoff.client.loans', '/home/loans', 'get')]
	public function loans() {
		/** @var Loans */
		$loan_repo = $this->db->repo(Loans::class);
		$this->page('client-loans.php', [
			'title' => 'Perstamos',
			'loans' => $loan_repo->accountLoans($this->session->get('uid')),
		]);
	}

	#[Route('madoff.client.loan', '/home/loan', 'get')]
	public function loan(array &$request) {
		/** @var Loans */
		$loan_repo = $this->db->repo(Loans::class);
		$this->page('client-loan.php', [
			'title' => 'Prestamo',
			'loan' => $loan_repo->getById($request['params']['id'] ?? 0),
			'debts' => $loan_repo->getDebts($request['params']['id'] ?? 0),
		]);
	}

	#[Route('madoff.loan.before_pay', '/home/loan/pay', 'get')]
	public function loan_before_pay(array &$request) {
		/** @var Loans */
		$loan_repo = $this->db->repo(Loans::class);
		$this->page('pay-loan.php', [
			'title' => 'Pagar prestamo',
			'loan' => $loan_repo->getById($request['params']['id'] ?? 0),
		]);
	}

	#[Route('madoff.loan.pay', '/home/loan/deposit', 'get')]
	public function loan_pay(array &$request) {
		/** @var Loans */
		try {
			$loan_repo = $this->db->repo(Loans::class);
			$loan_repo->depositLoan($this->session->get('uid'), $request['params']['id'] ?? 0);
			redirect('/home');
		} catch(Exception $ex) {
			if ($ex->getMessage() == 'The debt does not exist')
				 throw new Message('No hay una deuda actual', 'Regrese el siguinte mes para pagar la deuda');
		}
	}
}

