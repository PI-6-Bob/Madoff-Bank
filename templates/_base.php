<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= e($title ?? null) ?> ~ Madoff</title>
	<link rel="stylesheet" href="/assets/global.css">
	<link rel="icon" href="/assets/favicon.svg" type="image/svg+xml">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" defer>
	<?php foreach ($_styles ?? [] as $href): ?>
		<link rel="stylesheet" href="/assets/<?= u($href) ?>">
	<?php endforeach ?>
	<script src="/src/main.js" type="module" defer></script>
	<?php foreach ($_scripts ?? [] as $src): ?>
		<script src="/src/<?= u($src) ?>" type="module" defer></script>
	<?php endforeach ?>
</head>
<body>
<?php 
if (isset($_session)) {
	include 'templates/include/header-user.php';
	include "templates/include/nav-{$_session['role']}.php";
} else {
	include 'templates/include/header-anon.php';
}
?>
	<main id='content'>
		<?php include "templates/$_file" ?>
	</main>
</body>
</html>

