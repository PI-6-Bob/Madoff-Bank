<main>
	<h1 class="title"><?= e($message->getTitle()) ?></h1>
	<p><?= e($message->getMessage()) ?></p>
	<a class="btn" href="<?= e($referer ?? '/') ?>">Regresar</a>
</main>

