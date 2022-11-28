<?php

# Dump a variable metadata
function dump(mixed $val) {
	header('Content-Type: application/json');
	echo json_encode($val, JSON_PRETTY_PRINT);
	die;
}

function page(string $_file, array $_context = []) {
	header('Content-Type: text/html');
	extract($_context);
	include 'templates/_base.php';
}

function redirect(string $uri) {
	header("Location: $uri");
	die;
}

function e(mixed $string) {
	return htmlspecialchars($string ?? '');
}

function u(mixed $string) {
	return urlencode($string ?? '');
}
