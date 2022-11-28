<?php

namespace src\Controller;

use src\Attribute\IsLogged;
use Controller;
use libs\Attribute\Route;

#[IsLogged('executive')]
class Executive extends Controller 
{
	#[Route('madoff.executive.withdrawal', '/executive/withdrawal')]
	public function withdrawal() {
		return $this->page('executive-withdrawal.php', [
		]);
	}

	#[Route('madoff.executive.transactions', '/executive/transaction')]
	public function transactions() {
		return $this->page('executive-transactions.php', [
		]);
	}

	#[Route('madoff.executive.deposit', '/executive/deposit')]
	public function deposit() {
		return $this->page('executive-deposit.php', [
		]);
	}
}
