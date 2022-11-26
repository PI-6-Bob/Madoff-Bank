<?php

require_once "libs/kernel.php";
use src\Controller as Cont;
use src\Task as Task;
use src\Service as Serv;

(new App([
	Cont\Index::class,
	Serv\Test::class,
]))->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
