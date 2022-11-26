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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title ?? 'Madoff' ?></title>
	<link rel="stylesheet" href="/assets/global.css">
	<?php foreach ($_styles ?? [] as $href): ?>
		<link rel="stylesheet" href="/assets/<?= $href ?>">
	<?php endforeach ?>
	<script src="/assets/main.js" defer></script>
	<?php foreach ($_scripts ?? [] as $src): ?>
		<script src="/assets/<?= $src ?>" defer></script>
	<?php endforeach ?>
</head>
<body>
	<?php include "templates/$_file" ?>
</body>
</html>
<?php
}



