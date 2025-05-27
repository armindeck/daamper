<?php global $Panel; ?>
<section class="panel">
	<div class="form">
		<p><strong><?= Language(['directory', 'directory'], 'dashboard') ?></strong></p><hr>
		<style type="text/css">
			.check-bt-crear-archivo ~ .div-bt-crear-archivo,
			.check-bt-crear-carpeta ~ .div-bt-crear-carpeta,
			.check-bt-eliminar-carpeta ~ .div-bt-eliminar-carpeta { display: none; }
			.check-bt-crear-archivo:checked ~ .div-bt-crear-archivo,
			.check-bt-crear-carpeta:checked ~ .div-bt-crear-carpeta,
			.check-bt-eliminar-carpeta:checked ~ .div-bt-eliminar-carpeta { display: block; }
		</style>
		<input style="display:none;" type="checkbox" class="check-bt-crear-archivo" id="check-bt-crear-archivo">
		<input style="display:none;" type="checkbox" class="check-bt-crear-carpeta" id="check-bt-crear-carpeta">
		<input style="display:none;" type="checkbox" class="check-bt-eliminar-carpeta" id="check-bt-eliminar-carpeta">
		<div>
			<label class="check-bt-crear-archivo" for="check-bt-crear-archivo"><a class="boton-2"><i class="fas fa-plus"></i> <?= Language(['directory', 'create-file'], 'dashboard') ?></a></label>
			<label class="check-bt-crear-carpeta" for="check-bt-crear-carpeta"><a class="boton-2"><i class="fas fa-folder-plus"></i> <?= Language(['directory', 'create-folder'], 'dashboard') ?></a></label>
			<?php if($Panel['ap_directorio_dir']!='../'){ ?>
			<label class="check-bt-eliminar-carpeta" for="check-bt-eliminar-carpeta"><a class="boton-2"><i class="fas fa-trash"></i> <?= Language(['directory', 'delete-folder'], 'dashboard') ?></a></label>
			<?php } ?>
		</div>
		<form method="post" class="div-bt-crear-archivo">
			<input type="text" name="archivo" placeholder="<?= Language(['directory', 'file'], 'dashboard') ?>" pattern="[a-zA-Z0-9_-.]+" minlength="1">
			<input class="boton" type="submit" name="crear_archivo_boton" value="<?= Language(['directory', 'create-file'], 'dashboard') ?>">
		</form>
		<form method="post" class="div-bt-crear-carpeta">
			<input type="text" name="carpeta" placeholder="<?= Language(['directory', 'folder'], 'dashboard') ?>" pattern="[a-zA-Z0-9_-.]+" minlength="1">
			<input class="boton" type="submit" name="crear_carpeta_boton" value="<?= Language(['directory', 'create-folder'], 'dashboard') ?>">
		</form>
		<?php if($Panel['ap_directorio_dir']!='../'){ ?>
		<form method="post" class="div-bt-eliminar-carpeta"><hr>
			<label><?= Language(['directory', 'delete-folder-text'], 'dashboard') ?></label><br>
			<select name="confirmar">
				<option value="No"><?= Language('no') ?></option>
				<option value="Si"><?= Language('yes') ?></option>
			</select>
			<input class="boton" type="submit" name="eliminar_carpeta_boton" value="<?= Language(['directory', 'delete-folder'], 'dashboard') ?>">
		</form>
		<?php } ?>

		<hr>
<?php
$directories = []; $files = [];
foreach (glob($Panel['ap_directorio_dir'].'*') as $key => $value) {
	if(basename($value) != 'historial.txt'){
		if(is_dir($value)){ $directories[] = $value; } else { $files[] = $value; }
	}
}
echo count($directories) > 0 ? "<small>" . Language("directories") . "</small>" : "";
foreach ($directories as $key => $value) {
	echo '<a class="boton-2" href="?ap=directory&dir='.$value.'/"><i class="fas fa-folder-open"></i> '.basename(SCRIPTS->quitarPuntoEslas($value)).'</a>';
}

echo count($directories) > 0 && count($files) > 0 ? "<br>" : "";
echo count($files) > 0 ? "<small>" . Language("files") . "</small>" : "";
$images = [];
foreach (DATA->Config("default")["global"]["upload-image"]["support"] as $key => $value) {
	$images[] = str_replace("image/", "", $value);
}

foreach ($files as $key => $value) {
	if(in_array(pathinfo($value, PATHINFO_EXTENSION), $images)){
		echo "<section class='flex-evenly'>";
		break;
	}
}
foreach ($files as $key => $value) {
	if(!in_array(pathinfo($value, PATHINFO_EXTENSION), $images)){
		echo '<a class="boton" href="?ap=editor&dir='.$value.'" target="_blank"><i class="fas fa-file-code"></i> '.basename(SCRIPTS->quitarPuntoEslas($value)).'</a>';
	} else { ?>
		<section class="flex-column">
			<a href="<?= $value ?>" target="_blank">
				<img style="width: 100%; max-width: 150px;" src="<?= $value ?>" loading="lazy">
			</a>
			<footer>
				<a class="boton-2 boton-mini" href="?ap=editor&dir=<?= $value ?>" target="_blank">
					<i class="fas fa-edit"></i> <?= Language("edit") ?>
				</a>
			</footer>
		</section>
	<?php }
}
foreach ($files as $key => $value) {
	if(in_array(pathinfo($value, PATHINFO_EXTENSION), $images)){
		echo "</section>";
		break;
	}
}
if($Panel['ap_directorio_dir'] != '../'){
	echo '<hr><div><a href="?ap=directory&dir='.dirname($Panel['ap_directorio_dir']).'/" class="boton-2"><i class="fas fa-arrow-left"></i> '.Language('back').'</a></div>';
}
?>
<hr><?= SCRIPTS->xv('directory'); ?>
</div>
</section>