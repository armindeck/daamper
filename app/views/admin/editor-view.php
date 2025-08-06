<?php global $Panel; ?>
<section class="panel">
	<div class="form">
		<p><strong><?= Language('editor') ?></strong></p><hr>
		<section class="flex-between"><p><?= Language('file') ?>:</p> <small class="campo flex-1"><?= $Panel['ap_directorio_dir_completo']; ?></small></section>
		<style type="text/css">
			.check-bt-eliminar-archivo ~ .div-bt-eliminar-archivo { display: none; }
			.check-bt-eliminar-archivo:checked ~ .div-bt-eliminar-archivo { display: block; }
		</style>
		<input style="display:none;" type="checkbox" class="check-bt-eliminar-archivo" id="check-bt-eliminar-archivo">
		<form method="post" class="flex-column">
			<?php $images = []; $is_image = false;
			foreach (Daamper::$data->Config("default")["global"]["upload-image"]["support"] as $key => $value) {
				$images[] = str_replace("image/", "", $value);
			}
			if(in_array(pathinfo(basename($Panel['ap_directorio_dir_completo']), PATHINFO_EXTENSION), $images)){
				$is_image = true;
			}
			?>
			<?php if(!$is_image){ ?>
				<p><?= Language('content') ?>:</p>
				<textarea name="contenido" placeholder="<?= Language('content') ?>" style="min-height: 280px;"><?php if(file_exists($Panel['ap_directorio_dir_completo'])){ echo htmlspecialchars(file_get_contents($Panel['ap_directorio_dir_completo'])); } ?></textarea><hr>
			<?php } else { ?>
				<center>
					<a href="<?= $Panel['ap_directorio_dir_completo'] ?>" target="_blank">
						<img src="<?= $Panel['ap_directorio_dir_completo'] ?>" style="width: fit-content; max-width: 100%;" loading="lazy">
					</a>
				</center>
			<?php } ?>
			<div class="flex-between items-center">
				<?php if(!$is_image){ ?>
					<input class="boton" type="submit" name="guardar" value="<?= Language('save') ?>">
				<?php } ?>
				<?php if(file_exists($Panel['ap_directorio_dir_completo'])): ?>
					<label class="check-bt-eliminar-archivo" for="check-bt-eliminar-archivo">
						<a class="boton2"><i class="fas fa-trash"></i> <?= Language('delete') ?></a>
					</label>
				<?php endif; ?>
			</div>
		</form>
		<?php if(file_exists($Panel['ap_directorio_dir_completo'])): ?>
		<form method="post" class="div-bt-eliminar-archivo"><hr>
			<label><?= Language('delete-file-text-confirm') ?></label><hr>
			<select name="confirmar">
				<option value="No"><?= Language('no') ?></option>
				<option value="Si"><?= Language('yes') ?></option>
			</select>
			<input class="boton" type="submit" name="eliminar_archivo_boton" value="<?= Language('delete-file') ?>">
		</form>
		<?php $filedbhistory = $Web["directorio"] . "database/files/txt/history/editor/" .
			Daamper::$scripts->eslasToGuion(
				Daamper::$scripts->quitarPuntoEslas($Panel['ap_directorio_dir_completo'].'.txt')
			);  ?>
		<?php if(file_exists($filedbhistory)){ ?>
			<hr>Historial<hr>
			<textarea style="min-height: 100px;"><?php echo trim(htmlspecialchars(file_get_contents($filedbhistory))); ?></textarea>
		<?php } ?>
	<?php endif; ?>
	<hr><?php echo Daamper::$scripts->xv('editor'); ?>
</div>
</section>