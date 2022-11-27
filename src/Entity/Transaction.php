<?php

namespace src\Entity;

class Transaction
{
	public int $id;
	public int $from;
	public int $to;
	public string $when;
	public float $amount;
	public string $ubication;
	public bool $validated;
	public string $body;
}

