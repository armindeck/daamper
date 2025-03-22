<?php $Apartado='config'; ?>
<section class="panel">
	<style>.label-a > label { display: flex; flex-wrap:wrap; flex-direction: column; gap: 4px; }</style>
	<form method="post" class="label-a" action="procesa/procesa.panel.php">
		<b><?= LANGUAJE['global']['settings'][CONFIG['languaje']] ?></b><hr>
		<?= pInput(['name'=>'nombre_web','value'=>(isset($Web[$Apartado]['nombre_web']) ? $Web[$Apartado]['nombre_web'] : ''),'placeholder'=>(LANGUAJE['dashboard']['config']['page-name'][CONFIG['languaje']]),'texto'=>(LANGUAJE['dashboard']['config']['page-name'][CONFIG['languaje']]),'label'=>true]).
		pInput(['type'=>'url','name'=>'enlace_web','value'=>(isset($Web[$Apartado]['enlace_web']) ? $Web[$Apartado]['enlace_web'] : ''),'placeholder'=>'https://enlace.com','texto'=>(LANGUAJE['dashboard']['config']['page-link'][CONFIG['languaje']]),'label'=>true]).
		pInput(['name'=>'timezone','value'=>(isset($Web[$Apartado]['timezone']) ? $Web[$Apartado]['timezone'] : ''),'placeholder'=>'America/Bogota','texto'=>(LANGUAJE['dashboard']['config']['time-zone'][CONFIG['languaje']]),'label'=>true]).
		pInput(['type'=>'number','name'=>'ano_publicada','value'=>(isset($Web[$Apartado]['ano_publicada']) ? $Web[$Apartado]['ano_publicada'] : ''),'placeholder'=>'2024','texto'=>(LANGUAJE['dashboard']['config']['year-of-page-publication'][CONFIG['languaje']]),'label'=>true]).
		'<hr>'.(LANGUAJE['global']['enable'][CONFIG['languaje']]).':<div>'.
		pCheckboxBoton(['nameidclass'=>'https_imagen','texto'=>(LANGUAJE['dashboard']['config']['https-image'][CONFIG['languaje']]),'checked'=>(isset($Web[$Apartado]['https_imagen']) && $Web[$Apartado]['https_imagen']==$Web[$Apartado]['enlace_web'].'/' ? true : false)]).
		pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'php','texto2'=>'.PHP','title'=>(LANGUAJE['dashboard']['config']['php-title'][CONFIG['languaje']])]).
		pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'errores','texto2'=>(LANGUAJE['dashboard']['config']['errors'][CONFIG['languaje']]),'title'=>(LANGUAJE['dashboard']['config']['errors-title'][CONFIG['languaje']])]).'<hr>'.
		pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>(LANGUAJE['global']['update'][CONFIG['languaje']])]).
		'</div>'.'<hr>';
		?>
		<?= SCRIPTS->xv($Apartado); ?>
	</form>
</section>