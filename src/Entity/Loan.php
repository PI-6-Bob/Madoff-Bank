<?php

namespace src\Entity;

class Loan
{
	public int $id;
	public float $amount;
	public int $periods;
	public int $account_id;
	public float $interest;
	public float $periodic_payment;
	public string $date;
}

