<h1 class="title">¡Bienvenido <?= e($person->first_name) ?> <?= e($person->last_name) ?>!</h1>
<div class="_container">
<?php if ($_session['role'] == 'client'): ?>
    <h2 class="subtitle-2">Saldo en la billetera: $<?= e(number_format($user->balance)) ?></h2>
<?php elseif($_session['role'] == 'executive'): ?>
    <h2 class="subtitle-2">Clientes registrados: </h2>
<?php elseif($_session['role'] == 'admin'): ?>
    <h2 class="subtitle-2">Usuarios en la plataforma: </h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Correo</th>
            <th>Persona</th>
            <th>Saldo</th>
            <th>Estado</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= e($user->id) ?></td>
            <td>
                <a href="mailto:<?= u($user->email) ?>">
                    <?= e($user->email) ?>
                </a>
            </td>
            <td><?= e($user->person_id) ?></td>
            <td><?= e(number_format($user->balance)) ?></td>
            <td><?= e($user->status) ?></td>
        </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>
</div>
