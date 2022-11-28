<div class="_container">
	<h1 class="title centered">Iniciar sesion</h1>
	<form method="POST" action="/login">
		<input type="hidden" name="_target" value="<?= $_target ?>">
		<div class="field">
			<label for="email">Correo</label>
			<input type="email" name="_email" id="email">
		</div>
		<div class="field">
			<label for="password">Contraseña</label>
			<input type="password" name="_password" id="password">
		</div>
		<div class="field">
			<button class="_last centered">Entrar</button>
		</div>
	</form>
</div>

<style>
._container {
	margin: auto;
	max-width: fit-content;
}
</style>
