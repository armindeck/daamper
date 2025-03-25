<?php global $Panel; ?>
<section class="panel">
	<div class="form">
		<p><strong><?= Language(['directorio', 'directory'], 'dashboard') ?></strong></p><hr>
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
			<label class="check-bt-crear-archivo" for="check-bt-crear-archivo"><a class="boton-2"><i class="fas fa-plus"></i> <?= Language(['directorio', 'create-file'], 'dashboard') ?></a></label>
			<label class="check-bt-crear-carpeta" for="check-bt-crear-carpeta"><a class="boton-2"><i class="fas fa-folder-plus"></i> <?= Language(['directorio', 'create-folder'], 'dashboard') ?></a></label>
			<?php if($Panel['ap_directorio_dir']!='../'){ ?>
			<label class="check-bt-eliminar-carpeta" for="check-bt-eliminar-carpeta"><a class="boton-2"><i class="fas fa-trash"></i> <?= Language(['directorio', 'delete-folder'], 'dashboard') ?></a></label>
			<?php } ?>
		</div>
		<form method="post" class="div-bt-crear-archivo">
			<input type="text" name="archivo" placeholder="<?= Language(['directorio', 'file'], 'dashboard') ?>" pattern="[a-zA-Z0-9_-.]+" minlength="1">
			<input class="boton" type="submit" name="crear_archivo_boton" value="<?= Language(['directorio', 'create-file'], 'dashboard') ?>">
		</form>
		<form method="post" class="div-bt-crear-carpeta">
			<input type="text" name="carpeta" placeholder="<?= Language(['directorio', 'folder'], 'dashboard') ?>" pattern="[a-zA-Z0-9_-.]+" minlength="1">
			<input class="boton" type="submit" name="crear_carpeta_boton" value="<?= Language(['directorio', 'create-folder'], 'dashboard') ?>">
		</form>
		<?php if($Panel['ap_directorio_dir']!='../'){ ?>
		<form method="post" class="div-bt-eliminar-carpeta"><hr>
			<label><?= Language(['directorio', 'delete-folder-text'], 'dashboard') ?></label><br>
			<select name="confirmar">
				<option value="No"><?= Language('no') ?></option>
				<option value="Si"><?= Language('yes') ?></option>
			</select>
			<input class="boton" type="submit" name="eliminar_carpeta_boton" value="<?= Language(['directorio', 'delete-folder'], 'dashboard') ?>">
		</form>
		<?php } ?>

		<hr>
<?php
foreach (glob($Panel['ap_directorio_dir'].'*') as $key => $value) {
	if(basename($value)!='historial.txt'){
		echo '<a class="';
		if(is_dir($value)){
			echo 'boton-2" href="?ap=directorio&dir='.$value.'/"><i class="fas fa-folder-open"></i> ';
		} else {
			echo 'boton" href="?ap=editor&dir='.$value.'" target="_blank"><i class="fas fa-file-code"></i> ';
		}
		echo basename(SCRIPTS->quitarPuntoEslas($value)).'</a>';
	}
}
if($Panel['ap_directorio_dir'] != '../'){
	echo '<hr><div><a href="?ap=directorio&dir='.dirname($Panel['ap_directorio_dir']).'/" class="boton-2"><i class="fas fa-arrow-left"></i> '.Language('back').'</a></div>';
}
?>
<hr><?= SCRIPTS->xv('directorio'); ?>
</div>
</section>