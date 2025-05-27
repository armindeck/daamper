<?php $Apartado='upload-image'; ?>
<section class="panel">
	<form method="post" action="process/actions.php" enctype="multipart/form-data">
		<strong><?= Language('upload-images') ?></strong><hr>
		<p><?= Language(['upload-image', 'recommended'], 'dashboard', ['value' => '<a target="_blank" rel="nofollow" href="https://tinypng.com/">TinyPNG</a>']) ?></p><hr>
		<?=
		pInput(['type'=>'file','name'=>'imagen','texto'=>Language(['upload-image', 'select-image'], 'dashboard'),'label'=>true,'required'=>true]).'<hr>'.
		pInput(['name'=>'imagen_nombre','placeholder'=>Language(['upload-image', 'image-name'], 'dashboard'),'texto'=>Language('name') . ' ('.Language('optional').')','label'=>true])
		?>
		<hr>
		<section>
			<?= pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>Language('upload-image')]) ?>
		</section><hr>
		<?= SCRIPTS->xv($Apartado) ?>
	</form>
</section>