<div class="title">
	<h1>Prestamo</h1>
	<p class="subtitle-2">$<?= e(number_format($loan->amount)) ?> a <?= e($loan->periods) ?> meses desde el <?= e(date('d/M/Y', strtotime($loan->date))) ?></p>
</div>
<nav class="title-4">
	<a class="btn material-icons" title="Pagar" href="/home/loan/pay?id=<?= e($loan->id) ?>">attach_money</a>
</nav>
<table>
  <colgroup>
    <col class="_id">
    <col class="_due_to">
    <col class="_amount">
    <col class="_amount">
    <col class="_transaction">
  </colgroup>
  <thead>
      <tr>
          <th>Id</th>
          <th>Fecha limite</th>
          <th>Cantidad</th>
          <th>Pagado</th>
      </tr>
  </thead>
  <tbody>
  <?php if (!empty($debts)): ?>
      <?php foreach ($debts as $debt): ?>
      <tr>
          <td class="centered"><?= e($debt->id) ?></td>
          <td class="centered"><?= e(date('d/M/Y', strtotime($debt->due_to))) ?></td>
          <td class="centered">$<?= e(number_format($loan->amount)) ?></td>
          <td class="centered"><?= e($debt->transaction? 'Pagado' : 'Sin pagar') ?></td>
      </tr>
      <?php endforeach ?>
  <?php else: ?>
      <tr class="centered noresults">
          <td colspan="6" class="subtitle-1 muted">No hubo resultados</td>
      </tr>
  <?php endif ?>
  </tbody>
</table>
