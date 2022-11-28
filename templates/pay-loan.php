<div class="title">
	<h1>Pagar prestamo</h1>
</div>
<p>¿Desea depositar al prestamo?: $<?= e(number_format($loan->periodic_payment)) ?></p>
<a class="btn" href="/home/loan/deposit?id=<?= e($_params['id'] ?? 0) ?>">Pagar</a>
<a class="btn" href="<?= e($referer ?? '/') ?>">Regresar</a>
