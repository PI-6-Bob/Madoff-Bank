<h2 class="title centered">Prestamos</h2>
<div>
    <?php include 'templates/include/pager.php' ?>
</div>
<table>
    <colgroup>
        <col class="_id">
        <col class="_body">
        <col class="_amount">
    <thead>
        <tr>
            <th>Id</th>
            <th>Cantidad</th>
            <th>Periodos</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($loans)): ?>
        <?php foreach ($loans as $loan): ?>
        <tr>
            <td class="centered"><?= e($loan->id) ?></td>
            <td class="centered">$<?= e(number_format($loan->amount)) ?></td>
            <td><?= e($loan->periods) ?></td>
            <td><?= e($loan->status? 'Pagado' : 'En deuda') ?></td>
            <td>
                <nav class="actions">
                    <a class="btn material-icons" href="/home/loan?id=<?= e($loan->id) ?>">visibility</a>
                </nav>
            </td>
        </tr>
        <?php endforeach ?>
    <?php else: ?>
        <tr class="centered noresults">
            <td colspan="6" class="subtitle-1 muted">No hubo resultados</td>
        </tr>
    <?php endif ?>
    </tbody>
</table>

