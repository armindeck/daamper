<?php if(isset($_SESSION['mensaje_span'])): ?>
	<style type="text/css">
		.check-mensaje-span:checked + section { display: none; }
	</style>
	<input type="checkbox" class="check-mensaje-span" id="check-mensaje-span" hidden>
	<section class="div-mensaje-span mensaje-span" style="width: 100%; color: <?= $_SESSION['mensaje_span']['co']; ?>; background: <?= $_SESSION['mensaje_span']['bg']; ?>;">
		<p><?= $_SESSION['mensaje_span']['text']; ?></p>
		<label for="check-mensaje-span"><a><i class="fas fa-times-circle"></i></a></label>
	</section>
<?php endif; ?>