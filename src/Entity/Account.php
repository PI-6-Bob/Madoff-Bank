<?php

namespace src\Entity;

class Account 
{
	public int $id;
	public string $email;
	public string $phone;
	public int $person_id;
	public string $role;
	public string $password;
	public float $balance;
	public bool $status;
}
