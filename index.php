<?php

require_once "libs/kernel.php";
use src\Controller as Cont;
use src\Service as Serv;

(new App([
	Cont\Index::class,
	Cont\Home::class,
	Cont\Executive::class,
	Cont\Accounts::class,
	Cont\Client::class,
	Serv\IsLogged::class,
]))->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
