<?php $Apartado='htaccess';
$Web["htaccess"] = Daamper::$data->Config()["htaccess"] ?? [];
?>
<section class="panel">
	<form method="post" action="process/actions.php">
		<strong>HTACCESS</strong><hr>
		<b><?= Language(['htaccess', 'error-page-links'], 'dashboard') ?>:</b><hr>
		<?php
		$lista_errores = [400,401,403,404,500,503];
		foreach ($lista_errores as $key => $value) {
			echo pInput(['placeholder'=>'https://.com/'.$value,'title'=>$value . ' ' . (Language(['htaccess', $value], 'dashboard')),'name'=>'error_'.$value,'label'=>true,'class_label'=>'flex-column', 'texto'=>$value . ' ' . (Language(['htaccess', $value], 'dashboard')),'type'=>'url','value'=>(isset($Web[$Apartado]['error_'.$value]) ? $Web[$Apartado]['error_'.$value] : ''),'required'=>true]);
		} ?>
		<hr>
		<b><?= Language('enable') ?>:</b><hr>
		<section>
			<?php foreach (['todo_https' => 'ssl-https', 'errores' => 'errors', 'timezone' => 'time-zone'] as $key => $value) {
				echo pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>$key,'texto2'=>Language(['htaccess', $value], 'dashboard'),'title'=>Language(['htaccess', "$value-title"], 'dashboard')]);
			}
			?>
		</section>
		<hr>
		<section>
			<?= pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>Language('update')]) ?>
		</section>
		<hr>
		<?= Daamper::$scripts->xv($Apartado) ?>
	</form>
</section>