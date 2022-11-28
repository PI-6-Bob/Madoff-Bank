<h2 class="subtitle-2">Cuentas en la plataforma: </h2>
<div>
    <a class="btn" href="/admin/user/new">Nuevo usuario</a>
    <?php include 'templates/include/pager.php' ?>
</div>
<table>
    <colgroup>
        <col class="_id">
        <col class="_email">
        <col class="_balance">
        <col class="_status">
        <col class="_actions">
    <thead>
        <tr>
            <th>No. Cuenta</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Saldo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($users)): ?>
        <?php foreach ($users as $user): ?>
        <tr>
            <td class="centered"><?= e($user->id) ?></td>
            <td>
                <a href="mailto:<?= e($user->email) ?>">
                    <?= e($user->email) ?>
                </a>
            </td>
            <td class="centered"><?= e($user->role) ?></td>
            <td class="centered">$<?= e(number_format($user->balance)) ?></td>
            <td class="centered"><?= e($user->status? 'Activo' : 'Inactivo') ?></td>
            <td>
                <nav class="actions">
                    <a class="btn material-icons" href="/admin/user?id=<?= e($user->id) ?>">visibility</a>
                    <a class="btn material-icons" href="/admin/user/edit?id=<?= e($user->id) ?>">edit</a>
                    <a class="btn material-icons" href="/admin/user/delete?id=<?= e($user->id) ?>">delete</a>
                    <?php if ($user->status): ?>
                    <a class="btn material-icons" href="/admin/user/ban?id=<?= e($user->id) ?>">remove_circle_outline</a>
                    <?php else: ?>
                    <a class="btn material-icons" href="/admin/user/unban?id=<?= e($user->id) ?>">add_circle_outline</a>
                    <?php endif ?>
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
