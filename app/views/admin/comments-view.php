<center><strong><?= Language('comments') ?></strong></center>

<?php if(!isset($_GET["cantidad_comentarios"]) && !isset($_GET["orden_comentarios"])) {
	$_GET["orden_comentarios"] = "desc";
	$_GET["cantidad_comentarios"] = 10;
} ?>
<?php FormComentario(true) ?>