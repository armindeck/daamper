<?php $Apartado='config'; ?>
<section class="panel">
	<style>.label-a > label { display: flex; flex-wrap:wrap; flex-direction: column; gap: 4px; }</style>
	<form method="post" class="label-a" action="process/actions.php">
		<b><?= Language('settings') ?></b><hr>
		<?= pInput(['name'=>'nombre_web','value'=>(isset($Web[$Apartado]['nombre_web']) ? $Web[$Apartado]['nombre_web'] : ''),'placeholder'=>Language(['config', 'page-name'], 'dashboard'),'texto'=>Language(['config', 'page-name'], 'dashboard'),'label'=>true]).
		pInput(['type'=>'url','name'=>'enlace_web','value'=>(isset($Web[$Apartado]['enlace_web']) ? $Web[$Apartado]['enlace_web'] : ''),'placeholder'=>'https://'.(strtolower(Language('link'))).'.com','texto'=>Language(['config', 'page-link'], 'dashboard'),'label'=>true]).
		pInput(['name'=>'timezone','value'=>(isset($Web[$Apartado]['timezone']) ? $Web[$Apartado]['timezone'] : ''),'placeholder'=>'America/Bogota','texto'=>Language(['config', 'time-zone'], 'dashboard'),'label'=>true]).
		pInput(['type'=>'number','name'=>'ano_publicada','value'=>(isset($Web[$Apartado]['ano_publicada']) ? $Web[$Apartado]['ano_publicada'] : ''),'placeholder'=>'2024','texto'=>Language(['config', 'year-of-page-publication'], 'dashboard'),'label'=>true]).
		pSelect(['name' => 'language', 'label' => true, 'value' => Daamper::$config['language'], 'texto' => Language('language'), 'option' => Daamper::$data->Read('config/language')['global']['languages-options'][(isset($_SESSION['tmp']['language']) ? $_SESSION['tmp']['language'] : Daamper::$config['language'])]]) ?>
		<?= pSelectArchivos(['name' => 'theme', 'style' => 'width: 100%', 'value' => $Web[$Apartado]["theme"] ?? "", 'label' => true, 'texto' => Language('theme'), 'ruta' => $Web['directorio'].'assets/css/', 'tipo_archivos' => 'css', 'value-devuelve' => 'basename', 'hidden-extension-value' => true]) ?>
		<?= pSelect(['name' => 'color', 'style' => 'width: 100%', 'label' => true, 'value' => $Web[$Apartado]["color"], 'texto' => Language('default-color'), 'option' => Daamper::$scripts->optenerTemas("{$Web['directorio']}assets/css/{$Web["config"]["theme"]}")]) ?>
		<?=
		'<hr>'.(Language('enable')).':<div>'.
		pCheckboxBoton(['nameidclass'=>'https_imagen','texto'=>Language(['config', 'https-image'], 'dashboard'),'checked'=>(isset($Web[$Apartado]['https_imagen']) && $Web[$Apartado]['https_imagen']==$Web[$Apartado]['enlace_web'].'/' ? true : false)]).
		pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'php','texto2'=>'.PHP','title'=>Language(['config', 'php-title'], 'dashboard')]).
		pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'errores','texto2'=>Language(['config', 'errors'], 'dashboard'),'title'=>Language(['config', 'errors-title'], 'dashboard')])
		?>
		<?= "<hr>".
		pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>Language('update')]).
		'</div>'.'<hr>';
		?>
		<?= Daamper::$scripts->xv($Apartado); ?>
	</form>
</section>