<?php

namespace src\Entity;

class Loan
{
	public int $id;
	public float $amount;
	public int $periods;
	public int $account_id;
	public bool $status;
}

