<?= pSelectArchivos(['style' => 'width: 100%;', 'name'=>'referencia','referencia' => ['anime','hentai'],'texto'=>'Referencia','ruta'=>$Web['directorio'].'app/database/publicaciones/pu_','tipo_archivos'=>'php','value-devuelve'=>'basename']) ?>
<?= pInput(['name'=>'stream_default','type'=>'url','placeholder'=>'Stream default','texto'=>'Stream default','required'=>true]) ?>

<?php $lista_servidores['stream'] = [
	'MEGA','Uqload','Stream Wish','Lulu Stream','Voe','Stape','Netu','YourUpload','Okru','MP4Upload',
	'Filemoon','Dood Stream','StreamTape','YouTube'
];

$lista_servidores['descarga'] = [
	'MEGA','MediaFire','FireLoad','Gofile','Stream Wish','Stape'
];

$anime_mirando['cantidad_servidor_stream'] = 3;
$anime_mirando['cantidad_servidor_descarga'] = 2;

if(isset($_SESSION['tmpForm']['cantidad_servidor_stream'])){
	$anime_mirando['cantidad_servidor_stream'] = $_SESSION['tmpForm']['cantidad_servidor_stream'];
}

if(isset($_SESSION['tmpForm']['cantidad_servidor_descarga'])){
	$anime_mirando['cantidad_servidor_descarga'] = $_SESSION['tmpForm']['cantidad_servidor_descarga'];
}
foreach (['stream', 'descarga'] as $key => $value) { ?>
	<details>
		<summary><?= ucfirst($value) ?></summary>
		<section class="flex-column">
			<?php for($i_local = 1; $i_local <= $anime_mirando['cantidad_servidor_' . $value]; $i_local++){
				echo pSelect(['name'=>'servidor_'.$value.'_'.$i_local, 'texto'=>'Servidor:','option'=> $lista_servidores[$value]]).' '.
				pInput(['name'=>'servidor_'.$value.'_'.$i_local.'_enlace','type'=>'url','placeholder'=>'Enlace']);
				echo $value == 'descarga' ?
					pInput(['name'=>'servidor_'.$value.'_'.$i_local.'_enlace_acortado','type'=>'url','placeholder'=>'Enlace acortado']) : '';
			} ?>
		</section>
	</details>
<?php } ?>
<section class="flex-between">
	<?= pInput(['name'=>'cantidad_servidor_stream','type'=>'number','min'=>1,'class'=>'campo form-campo-pequeno','placeholder'=>'1','label'=>true,'texto'=>'Stream','value'=>$anime_mirando['cantidad_servidor_stream'],'required'=>true]) ?>
	<?= pInput(['name'=>'cantidad_servidor_descarga','type'=>'number','min'=>1,'class'=>'campo form-campo-pequeno','placeholder'=>'1','label'=>true,'texto'=>'Descarga','value'=>$anime_mirando['cantidad_servidor_descarga'],'required'=>true]) ?>
	<?= pInput(['name'=>'episodio','type'=>'number','min'=>0,'value'=>1,'class'=>'campo form-campo-pequeno','placeholder'=>'1','label'=>true,'texto'=>'Episodio','required'=>true]) ?>
</section>