<h2 class="subtitle-2">Saldo en la billetera: $<?= e(number_format($user->balance)) ?></h2>
<h2 class="subtitle-3 centered">Movimientos</h2>
<div>
    <a class="btn" href="/home/transaction">Transferir</a>
    <?php include 'templates/include/pager.php' ?>
</div>
<table>
    <colgroup>
        <col class="_id">
        <col class="_body">
        <col class="_amount">
    </colgroup>
    <thead>
        <tr>
            <th>Id</th>
            <th>Concepto</th>
            <th>Cantidad</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($transactions)): ?>
        <?php foreach ($transactions as $trans): ?>
        <tr>
            <td class="centered"><?= e($trans->id) ?></td>
            <td><?= e($trans->body ?? "Transaccion a la cuenta {$trans->to}") ?></td>
            <td class="centered"> <?= ($trans->him ?? 1) > 0? '-' : '+'?> $<?= e(number_format($trans->amount)) ?></td>
            <td>
                <nav class="actions">
                    <a class="btn material-icons" href="/admin/user?id=<?= e($user->id) ?>">visibility</a>
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
