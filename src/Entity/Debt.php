<?php

namespace src\Entity;

class Debt 
{
	public int $id;
	public int $loan;
	public string $due_to;
	public int $transaction;
}
