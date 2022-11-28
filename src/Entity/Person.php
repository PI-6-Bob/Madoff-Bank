<?php

namespace src\Entity;

class Person 
{
	public int $id;
	public string $first_name;
	public string $last_name;
	public string $birth_date;
	public string $registered_on;
	public string $curp;
	public ?string $address;
	public string $rfc;
	public string $marital_status;
}
