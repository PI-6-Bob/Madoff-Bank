<h1 class="title">¡Bienvenido <?= e($person->first_name) ?> <?= e($person->last_name) ?>!</h1>
<div class="_container">
    <?php include "templates/home-{$_session['role']}.php" ?>
</div>

<style>
._id { width: min-content; }
._email { width: 100%; }
</style>
