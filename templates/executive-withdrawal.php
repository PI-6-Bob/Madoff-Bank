<div class="_container">
	<h1 class="title centered">Retiro</h1>
	<form method="POST" action="/executive/withdraw">
		<input type="hidden" name="_target" value="<?= $_target ?? '/home' ?>">
		<div class="field">
			<label for="account">Cuenta</label>
			<input type="number" name="_account" id="account">
		</div>
		<div class="field">
			<label for="amount">Cantidad</label>
			<input type="text" name="_amount" id="amount">
		</div>
		<div class="field">
			<button class="_last centered">Retirar</button>
		</div>
	</form>
</div>

<style>
._container {
	margin: auto;
	max-width: fit-content;
}
</style>


