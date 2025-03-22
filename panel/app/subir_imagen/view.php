<?php $Apartado='subir_imagen'; ?>
<section class="panel">
	<form method="post" action="procesa/procesa.panel.php" enctype="multipart/form-data">
		<strong><?= LANGUAJE['global']['upload-images'][CONFIG['languaje']] ?></strong><hr>
		<p><?= LANGUAJE['dashboard']['subir-imagen']['recommended'][CONFIG['languaje']][0] ?><a target="_blank" rel="nofollow" href="https://tinypng.com/">TinyPNG</a><?= LANGUAJE['dashboard']['subir-imagen']['recommended'][CONFIG['languaje']][1] ?></p><hr>
		<?=
		pInput(['type'=>'file','name'=>'imagen','texto'=>LANGUAJE['dashboard']['subir-imagen']['select-image'][CONFIG['languaje']],'label'=>true,'required'=>true]).'<hr>'.
		pInput(['name'=>'imagen_nombre','placeholder'=>LANGUAJE['dashboard']['subir-imagen']['image-name'][CONFIG['languaje']],'texto'=>LANGUAJE['global']['name'][CONFIG['languaje']] . ' ('.LANGUAJE['global']['optional'][CONFIG['languaje']].')','label'=>true])
		?>
		<hr>
		<section>
			<?= pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>LANGUAJE['global']['upload-image'][CONFIG['languaje']]]) ?>
		</section><hr>
		<?= SCRIPTS->xv($Apartado) ?>
	</form>
</section>