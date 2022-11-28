<div class="_container">
	<h1 class="title centered">Nueva cuenta</h1>
	<form method="POST" action="/admin/account/new">
		<input type="hidden" name="_target" value="<?= $_target ?? '/home' ?>">
		<div class="field">
			<label for="email">Correo</label>
			<input type="email" name="_email" id="email">
		</div>
		<div class="field">
			<label for="password">Contraseña</label>
			<input type="password" name="_password" id="password">
		</div>
		<div class="field">
			<label for="phone">Telefono</label>
			<input type="phone" name="_phone" id="phone">
		</div>
		<div class="field">
			<label for="person">Persona</label>
			<input type="text" name="_person_id" id="person">
		</div>
		<div class="field">
			<label for="name">Nombre</label>
			<input type="text" name="_name" id="name">
		</div>
		<div class="field">
			<label for="last_name">Apellido</label>
			<input type="text" name="_last_name" id="last_name">
		</div>
		<div class="field">
			<label for="birth_date">Nacimiento</label>
			<input type="date" name="_birth_date" id="birth_date">
		</div>
		<div class="field">
			<button class="_last centered">Crear</button>
		</div>
	</form>
</div>

<style>
._container {
	margin: auto;
	max-width: fit-content;
}
</style>


