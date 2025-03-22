<?php global $Panel; ?>
<section class="panel">
	<div class="form">
		<p><strong><?= LANGUAJE['dashboard']['directorio']['directory'][CONFIG['languaje']] ?></strong></p><hr>
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
			<label class="check-bt-crear-archivo" for="check-bt-crear-archivo"><a class="boton-2"><i class="fas fa-plus"></i> <?= LANGUAJE['dashboard']['directorio']['create-file'][CONFIG['languaje']] ?></a></label>
			<label class="check-bt-crear-carpeta" for="check-bt-crear-carpeta"><a class="boton-2"><i class="fas fa-folder-plus"></i> <?= LANGUAJE['dashboard']['directorio']['create-folder'][CONFIG['languaje']] ?></a></label>
			<?php if($Panel['ap_directorio_dir']!='../'){ ?>
			<label class="check-bt-eliminar-carpeta" for="check-bt-eliminar-carpeta"><a class="boton-2"><i class="fas fa-trash"></i> <?= LANGUAJE['dashboard']['directorio']['delete-folder'][CONFIG['languaje']] ?></a></label>
			<?php } ?>
		</div>
		<form method="post" class="div-bt-crear-archivo">
			<input type="text" name="archivo" placeholder="<?= LANGUAJE['dashboard']['directorio']['file'][CONFIG['languaje']] ?>" pattern="[a-zA-Z0-9_-.]+" minlength="1">
			<input class="boton" type="submit" name="crear_archivo_boton" value="<?= LANGUAJE['dashboard']['directorio']['create-file'][CONFIG['languaje']] ?>">
		</form>
		<form method="post" class="div-bt-crear-carpeta">
			<input type="text" name="carpeta" placeholder="<?= LANGUAJE['dashboard']['directorio']['folder'][CONFIG['languaje']] ?>" pattern="[a-zA-Z0-9_-.]+" minlength="1">
			<input class="boton" type="submit" name="crear_carpeta_boton" value="<?= LANGUAJE['dashboard']['directorio']['create-folder'][CONFIG['languaje']] ?>">
		</form>
		<?php if($Panel['ap_directorio_dir']!='../'){ ?>
		<form method="post" class="div-bt-eliminar-carpeta"><hr>
			<label><?= LANGUAJE['dashboard']['directorio']['delete-folder-text'][CONFIG['languaje']] ?></label><br>
			<select name="confirmar">
				<option value="No"><?= LANGUAJE['global']['no'][CONFIG['languaje']] ?></option>
				<option value="Si"><?= LANGUAJE['global']['yes'][CONFIG['languaje']] ?></option>
			</select>
			<input class="boton" type="submit" name="eliminar_carpeta_boton" value="<?= LANGUAJE['dashboard']['directorio']['delete-folder'][CONFIG['languaje']] ?>">
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
	echo '<hr><div><a href="?ap=directorio&dir='.dirname($Panel['ap_directorio_dir']).'/" class="boton-2"><i class="fas fa-arrow-left"></i> '.(LANGUAJE['global']['back'][CONFIG['languaje']]).'</a></div>';
}
?>
<hr><?= SCRIPTS->xv('directorio'); ?>
</div>
</section>