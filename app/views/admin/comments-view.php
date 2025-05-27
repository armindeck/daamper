<section class="panel" style="padding: 0 4px 4px 4px;">
	<section class="form"><strong><?= Language('comments') ?></strong></section>
</section>
<section style="padding: 0 4px 4px 4px;">
	<?php if(!isset($_GET["cantidad_comentarios"]) && !isset($_GET["orden_comentarios"])) {
		$_GET["orden_comentarios"] = "desc";
		$_GET["cantidad_comentarios"] = 10;
	} ?>
	<?php FormComentario(true) ?>
</section>