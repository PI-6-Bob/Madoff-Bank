<div class="_container">
	<h1 class="title centered">Transaccion</h1>
	<form method="POST" action="/home/transaction/do" id="transaction">
		<input type="hidden" name="_target" value="<?= $_target ?? '/home' ?>">
		<div class="field">
			<label for="account">Numero de cuenta</label>
			<input type="text" name="_account" id="account">
		</div>
		<div class="field">
			<label for="amount">Cantidad</label>
			<input type="number" name="_amount" id="amount">
		</div>
		<div class="field">
			<label for="body">Concepto</label>
			<textarea name="_body" id="body" class="vs"></textarea>
		</div>
		<div class="field">
			<button class="_last centered">Transferir</button>
		</div>
	</form>
</div>

<style>
._container {
	margin: auto;
	max-width: fit-content;
}
</style>


