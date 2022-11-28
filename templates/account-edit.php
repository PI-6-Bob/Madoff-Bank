<?php $role_index = array_search($user->role, ['admin', 'executive', 'client']) ?>
<div class="_container">
	<h1 class="title centered">Editar cuenta</h1>
	<form method="POST" action="/admin/account/edit">
		<input type="hidden" name="_target" value="<?= $_target ?? '/home' ?>">
		<input type="hidden" name="_id" value="<?= $_params['id'] ?? 0 ?>">
		<div class="field">
			<label for="email">Correo</label>
			<input type="email" name="_email" id="email" placeholder="<?= e($user->email) ?>">
		</div>
		<div class="field">
			<label for="password">Contraseña</label>
			<input type="password" name="_password" id="password">
		</div>
		<div class="field">
			<label for="phone">Telefono</label>
			<input type="phone" name="_phone" id="phone" placeholder="<?= e($user->phone) ?>">
		</div>
		<div class="field">
			<label for="person">Persona</label>
			<input type="text" name="_person_id" id="person" placeholder="<?= e($user->person_id) ?>">
		</div>
		<div class="field">
			<label for="role">Rol</label>
      <select name="_role" id="role">
				<option value="2" <?= $role_index == 2? 'selected' : null ?>>Cliente</option>
				<option value="1" <?= $role_index == 1? 'selected' : null ?>>Ejecutivo</option>
        <option value="0" <?= $role_index == 0? 'selected' : null ?>>Admin</option>
      </select>
		</div>
		<div class="field">
			<button class="_last centered">Editar</button>
		</div>
	</form>
</div>

<style>
._container {
	margin: auto;
	max-width: fit-content;
}
</style>


