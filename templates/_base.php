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
	<script src="/src/main.js" type="module" defer></script>
	<?php foreach ($_scripts ?? [] as $src): ?>
		<script src="/src/<?= $src ?>" type="module" defer></script>
	<?php endforeach ?>
</head>
<body>
<?php 
if (isset($_session)):
		include 'templates/header-user.php';
else:
		include 'templates/header-anon.php';
endif ?>
	<main id='content'><?php include "templates/$_file" ?></main>
</body>
</html>

