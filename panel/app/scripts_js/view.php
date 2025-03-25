<?php $Apartado='scripts_js'; ?>
<section class="panel">
	<form method="post" action="procesa/procesa.panel.php">
		<strong><?= Language(['scripts_js', 'title'], 'dashboard') ?></strong><hr>
		<?=
		pTextarea(['placeholder'=>(Language(['scripts_js', 'google-placeholder'], 'dashboard')),'name'=>'scripts_js_google','value'=>(file_exists(__DIR__.'/web-scripts_js_google.html') ? htmlspecialchars(file_get_contents(__DIR__.'/web-scripts_js_google.html')) : ''),'style'=>'min-height:150px;','label'=>true,'texto'=>'Google']).
		pTextarea(['placeholder'=>(Language(['scripts_js', 'font-awesome-placeholder'], 'dashboard')),'required'=>true,'name'=>'scripts_js_font_awesome','value'=>(file_exists(__DIR__.'/web-scripts_js_font_awesome.html') ? htmlspecialchars(file_get_contents(__DIR__.'/web-scripts_js_font_awesome.html')) : ''),'style'=>'min-height:70px;','label'=>true,'texto'=>'Font Awesome']).
		pTextarea(['placeholder'=>(Language(['scripts_js', 'use-freely'], 'dashboard')),'required'=>false,'name'=>'scripts_js_otros','value'=>(file_exists(__DIR__.'/web-scripts_js_otros.html') ? htmlspecialchars(file_get_contents(__DIR__.'/web-scripts_js_otros.html')) : ''),'style'=>'min-height:150px;','label'=>true,'texto'=>(Language(['scripts_js', 'others'], 'dashboard'))])
		?>
		<hr><strong><?= Language('show') ?> <?= Language('scripts') ?></strong>
		<section>
			<?=
			pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_scripts_js_google','texto2'=>'Google']).
			pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_scripts_js_font_awesome','texto2'=>'Font Awesome']).
			pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_scripts_js_otros','texto2'=>Language(['scripts_js', 'others'], 'dashboard')])
			?>
			<hr>
			<?= pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>Language('update')]) ?>
		</section><hr>
		<?= SCRIPTS->xv($Apartado) ?>
	</form>
</section>