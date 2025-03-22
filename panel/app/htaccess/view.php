<?php $Apartado='htaccess';
if(file_exists(__DIR__.'/web-htaccess.php')){
	require __DIR__.'/web-htaccess.php';
}
?>
<section class="panel">
	<form method="post" action="procesa/procesa.panel.php">
		<strong>HTACCESS</strong><hr>
		<b><?= LANGUAJE['dashboard']['htaccess']['error-page-links'][CONFIG['languaje']] ?>:</b><hr>
		<?php
		$lista_errores = [400,401,403,404,500,503];
		foreach ($lista_errores as $key => $value) {
			echo pInput(['placeholder'=>'https://.com/'.$value,'title'=>$value . ' ' . (LANGUAJE['dashboard']['htaccess'][$value][CONFIG['languaje']]),'name'=>'error_'.$value,'label'=>true,'class_label'=>'flex-column', 'texto'=>$value . ' ' . (LANGUAJE['dashboard']['htaccess'][$value][CONFIG['languaje']]),'type'=>'url','value'=>(isset($Web[$Apartado]['error_'.$value]) ? $Web[$Apartado]['error_'.$value] : ''),'required'=>true]);
		} ?>
		<hr>
		<b><?= LANGUAJE['global']['enable'][CONFIG['languaje']] ?>:</b><hr>
		<section>
			<?php foreach (['todo_https' => 'ssl-https', 'errores' => 'errors', 'timezone' => 'time-zone'] as $key => $value) {
				echo pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>$key,'texto2'=>(LANGUAJE['dashboard']['htaccess'][$value][CONFIG['languaje']]),'title'=>(LANGUAJE['dashboard']['htaccess']["$value-title"][CONFIG['languaje']])]);
			}
			?>
		</section>
		<hr>
		<section>
			<?= pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>(LANGUAJE['global']['update'][CONFIG['languaje']])]) ?>
		</section>
		<hr>
		<?= SCRIPTS->xv($Apartado) ?>
	</form>
</section>