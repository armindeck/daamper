<?php $Apartado='scripts_js'; ?>
<section class="panel">
	<form method="post" action="procesa/procesa.panel.php">
		<strong><?= LANGUAJE['dashboard']['scripts_js']['title'][CONFIG['languaje']] ?></strong><hr>
		<?=
		pTextarea(['placeholder'=>(LANGUAJE['dashboard']['scripts_js']['google-placeholder'][CONFIG['languaje']]),'name'=>'scripts_js_google','value'=>(file_exists(__DIR__.'/web-scripts_js_google.html') ? htmlspecialchars(file_get_contents(__DIR__.'/web-scripts_js_google.html')) : ''),'style'=>'min-height:150px;','label'=>true,'texto'=>'Google']).
		pTextarea(['placeholder'=>(LANGUAJE['dashboard']['scripts_js']['font-awesome-placeholder'][CONFIG['languaje']]),'required'=>true,'name'=>'scripts_js_font_awesome','value'=>(file_exists(__DIR__.'/web-scripts_js_font_awesome.html') ? htmlspecialchars(file_get_contents(__DIR__.'/web-scripts_js_font_awesome.html')) : ''),'style'=>'min-height:70px;','label'=>true,'texto'=>'Font Awesome']).
		pTextarea(['placeholder'=>(LANGUAJE['dashboard']['scripts_js']['use-freely'][CONFIG['languaje']]),'required'=>false,'name'=>'scripts_js_otros','value'=>(file_exists(__DIR__.'/web-scripts_js_otros.html') ? htmlspecialchars(file_get_contents(__DIR__.'/web-scripts_js_otros.html')) : ''),'style'=>'min-height:150px;','label'=>true,'texto'=>(LANGUAJE['dashboard']['scripts_js']['others'][CONFIG['languaje']])])
		?>
		<hr><strong><?= LANGUAJE['global']['show'][CONFIG['languaje']] ?> scripts</strong>
		<section>
			<?=
			pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_scripts_js_google','texto2'=>'Google']).
			pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_scripts_js_font_awesome','texto2'=>'Font Awesome']).
			pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_scripts_js_otros','texto2'=>(LANGUAJE['dashboard']['scripts_js']['others'][CONFIG['languaje']])])
			?>
			<hr>
			<?= pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>(LANGUAJE['global']['update'][CONFIG['languaje']])]) ?>
		</section><hr>
		<?= SCRIPTS->xv($Apartado) ?>
	</form>
</section>