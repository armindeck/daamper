<?php if(isset($_SESSION["sendAlert"])): ?>
	<style type="text/css">
		.check-mensaje-span:checked + section { display: none; }
	</style>
	<input type="checkbox" class="check-mensaje-span" id="check-mensaje-span" hidden>
	<section class="div-mensaje-span mensaje-span alert alert--<?= $_SESSION["sendAlert"]["type"] ?? 'default' ?>">
		<p><?= $_SESSION["sendAlert"]["text"] ?? '' ?></p>
		<label for="check-mensaje-span"><a><i class="fas fa-times-circle"></i></a></label>
	</section>
<?php endif; ?>