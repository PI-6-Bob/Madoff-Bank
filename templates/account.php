<div class="title">
	<h1><?= e($user->email) ?></h1>
	<p class="subtitle"><?= e($user->role) ?></p>
</div>
<nav class="title-4">
  <a class="btn material-icons" title="Editar" href="/admin/user/edit?id=<?= e($user->id) ?>">edit</a>
  <a class="btn material-icons" title="Eliminar" href="/admin/user/delete?id=<?= e($user->id) ?>">delete</a>
  <?php if ($user->status): ?> 
  <a class="btn material-icons" title="Desactivar" href="/admin/user/ban?id=<?= e($user->id) ?>">remove_circle_outline</a>
  <?php else: ?> 
  <a class="btn material-icons" title="Activar" href="/admin/user/unban?id=<?= e($user->id) ?>">add_circle_outline</a>
  <?php endif ?>
</nav>

<div>
	<p><a title="Persona" href="/admin/person?id=<?= e($user->person_id) ?>">Dueño de la cuenta</a></p>
	<p>Saldo: <em class="remark"><?= e(number_format($user->balance)) ?></em></p>
	<p>Estado: <em class="remark"><?= e($user->status? 'Activo' : 'Inactivo') ?></em></p>
	<p>Telefono: <em class="remark"><?= e($user->phone) ?></em></p>
</div>

