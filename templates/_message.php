<main>
	<h1 class="title"><?= $message->getTitle() ?></h1>
	<p><?= $message->getMessage() ?></p>
	<a class="btn" href="<?= $referer ?? '/' ?>">Regresar</a>
</main>

