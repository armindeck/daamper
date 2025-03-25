<?php global $Panel; ?>
<section class="panel">
	<div class="form">
		<p><strong><?= Language('editor') ?></strong></p><hr>
		<style type="text/css">
			.check-bt-eliminar-archivo ~ .div-bt-eliminar-archivo { display: none; }
			.check-bt-eliminar-archivo:checked ~ .div-bt-eliminar-archivo { display: block; }
		</style>
		<input style="display:none;" type="checkbox" class="check-bt-eliminar-archivo" id="check-bt-eliminar-archivo">
		<form method="post" style="display: flex; flex-wrap: wrap; flex-direction: column;">
			<p><?= Language('file') ?>: <span class="t-14"><?= $Panel['ap_directorio_dir_completo']; ?></span></p>
			<hr><?= Language('content') ?>:<hr>
			<textarea name="contenido" placeholder="<?= Language('content') ?>" style="min-height: 280px;"><?php if(file_exists($Panel['ap_directorio_dir_completo'])){ echo htmlspecialchars(file_get_contents($Panel['ap_directorio_dir_completo'])); } ?></textarea><hr>
			<div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center;">
				<input class="boton" type="submit" name="guardar" value="<?= Language('save') ?>">
				<?php if(file_exists($Panel['ap_directorio_dir_completo'])): ?>
				<label class="check-bt-eliminar-archivo" for="check-bt-eliminar-archivo"><a class="boton2"><i class="fas fa-trash"></i> <?= Language('delete') ?></a></label>
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
		<?php if(file_exists(
				__DIR__.'/historial/'.
				SCRIPTS->eslasToGuion(
					SCRIPTS->quitarPuntoEslas(
						$Panel['ap_directorio_dir_completo'].'.txt'
					)
				)
			)){ ?>
		<hr>Historial<hr>
		<textarea style="min-height: 100px;"><?php echo trim(htmlspecialchars(file_get_contents(
		__DIR__.'/historial/'.
			SCRIPTS->eslasToGuion(
				SCRIPTS->quitarPuntoEslas(
					$Panel['ap_directorio_dir_completo'].'.txt'
				)
			)
		))); ?></textarea>
			<?php } ?>
	<?php endif; ?>
	<hr><?php echo SCRIPTS->xv('editor'); ?>
</div>
</section>