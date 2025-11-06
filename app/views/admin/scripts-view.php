<?php $Apartado='scripts'; ?>
<section class="panel">
	<form method="post" action="process/actions.php">
		<strong><?= Language(['scripts', 'title'], 'dashboard') ?></strong><hr>
		<?=
		pTextarea(['placeholder'=>(Language(['scripts', 'google-placeholder'], 'dashboard')),'name'=>'google_scripts','value'=> htmlspecialchars($Web[$Apartado]["google_scripts"] ?? ""),'style'=>'min-height:150px;','label'=>true,'texto'=>'Google']).
		pTextarea(['placeholder'=>(Language(['scripts', 'font-awesome-placeholder'], 'dashboard')),'required'=>true,'name'=>'font_awesome_scripts','value'=> htmlspecialchars($Web[$Apartado]["font_awesome_scripts"] ?? ""),'style'=>'min-height:70px;','label'=>true,'texto'=>'Font Awesome']).
		pTextarea(['placeholder'=>(Language(['scripts', 'use-freely'], 'dashboard')),'required'=>false,'name'=>'other_scripts','value'=> htmlspecialchars($Web[$Apartado]["other_scripts"] ?? ""),'style'=>'min-height:150px;','label'=>true,'texto'=>(Language(['scripts', 'others'], 'dashboard'))])
		?>
		<hr><strong><?= Language('show') ?> <?= Language('scripts') ?></strong>
		<section>
			<?=
			pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'show_google_scripts','texto2'=>'Google']).
			pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'show_font_awesome_scripts','texto2'=>'Font Awesome']).
			pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'show_other_scripts','texto2'=>Language(['scripts', 'others'], 'dashboard')])
			?>
			<hr>
			<?= pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>Language('update')]) ?>
		</section><hr>
		<?= Daamper::$scripts->xv($Apartado) ?>
	</form>
</section>