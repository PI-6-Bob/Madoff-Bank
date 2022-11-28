<main>
	<h1 class="title">Error del servidor</h1>
	<p>Ha sucedido un error</p>
	<?php if (!$_ENV['PRODUCTION']): ?>
	<pre style="margin: 2em 0;"><?= $error->getMessage() . "\n" ?><?= $error->getTraceAsString() ?></pre>
	<?php endif ?>
	<a class="btn" href="<?= $referer ?? '/' ?>">Regresar</a>
</main>

