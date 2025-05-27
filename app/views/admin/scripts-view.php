<?php $Apartado='scripts'; ?>
<section class="panel">
	<form method="post" action="process/actions.php">
		<strong><?= Language(['scripts', 'title'], 'dashboard') ?></strong><hr>
		<?=
		pTextarea(['placeholder'=>(Language(['scripts', 'google-placeholder'], 'dashboard')),'name'=>'scripts_google','value'=>(file_exists($Web["directorio"].'database/files/html/scripts_google.html') ? htmlspecialchars(file_get_contents($Web["directorio"].'database/files/html/scripts_google.html')) : ''),'style'=>'min-height:150px;','label'=>true,'texto'=>'Google']).
		pTextarea(['placeholder'=>(Language(['scripts', 'font-awesome-placeholder'], 'dashboard')),'required'=>true,'name'=>'scripts_font_awesome','value'=>(file_exists($Web["directorio"].'database/files/html/scripts_font_awesome.html') ? htmlspecialchars(file_get_contents($Web["directorio"].'database/files/html/scripts_font_awesome.html')) : ''),'style'=>'min-height:70px;','label'=>true,'texto'=>'Font Awesome']).
		pTextarea(['placeholder'=>(Language(['scripts', 'use-freely'], 'dashboard')),'required'=>false,'name'=>'scripts_otros','value'=>(file_exists($Web["directorio"].'database/files/html/scripts_otros.html') ? htmlspecialchars(file_get_contents($Web["directorio"].'database/files/html/scripts_otros.html')) : ''),'style'=>'min-height:150px;','label'=>true,'texto'=>(Language(['scripts', 'others'], 'dashboard'))])
		?>
		<hr><strong><?= Language('show') ?> <?= Language('scripts') ?></strong>
		<section>
			<?=
			pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_scripts_google','texto2'=>'Google']).
			pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_scripts_font_awesome','texto2'=>'Font Awesome']).
			pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_scripts_otros','texto2'=>Language(['scripts', 'others'], 'dashboard')])
			?>
			<hr>
			<?= pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>Language('update')]) ?>
		</section><hr>
		<?= SCRIPTS->xv($Apartado) ?>
	</form>
</section>