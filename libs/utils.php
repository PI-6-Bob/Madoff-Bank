<?php

# Dump a variable metadata
function dump(mixed $val) {
	header('Content-Type: application/json');
	echo json_encode($val, JSON_PRETTY_PRINT);
	die;
}

