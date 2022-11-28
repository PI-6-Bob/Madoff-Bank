<div class="title">
	<h1><?= $person->first_name ?> <?= $person->last_name ?></h1>
	<p class="subtitle">Miembro desde el: <em class="remark"><?= date('d/M/Y', strtotime($person->registered_on)) ?></em></p>
</div>

<div>
	<p>Fecha de nacimiento: <em class="remark"><?= date('d/M/Y', strtotime($person->birth_date)) ?></em></p>
	<p>CURP: <em class="remark"><?= $person->curp ?></em></p>
	<p>RFC: <em class="remark"><?= $person->rfc ?></em></p>
</div>
