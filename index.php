<?php

require_once "libs/kernel.php";
use src\Controller as Cont;
use src\Service as Serv;

(new App([
	Serv\Logged::class,
	Cont\Index::class,
	Cont\Home::class,
]))->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
