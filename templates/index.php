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
		<button>Entrar</button>
	</div>
</form>
