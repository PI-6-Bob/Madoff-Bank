<div class="title">
	<h1><?= e($person->first_name) ?> <?= e($person->last_name) ?></h1>
	<p class="subtitle">Miembro desde el: <em class="remark"><?= e(date('d/M/Y', strtotime($person->registered_on))) ?></em></p>
</div>

<div>
	<p>Fecha de nacimiento: <em class="remark"><?= e(date('d/M/Y', strtotime($person->birth_date))) ?></em></p>
	<p>CURP: <em class="remark"><?= e($person->curp) ?></em></p>
	<p>RFC: <em class="remark"><?= e($person->rfc) ?></em></p>
</div>
