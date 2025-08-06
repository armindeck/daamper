<?= pSelectArchivos(['style' => 'width: 100%;', 'name'=>'referencia','referencia' => ['anime','hentai'],'texto'=>Language('reference'),'ruta'=>$Web['directorio'].'database/post/','tipo_archivos'=>'json','value-devuelve'=>'basename']) ?>
<?= pInput(['name'=>'stream_default','type'=>'url','placeholder'=>Language('stream-default'),'texto'=>Language('stream-default'),'required'=>true]) ?>

<?php $lista_servidores['stream'] = Daamper::$data->Read('creator/default')['server']['streams'] ?? [];
$lista_servidores['descarga'] = Daamper::$data->Read('creator/default')['server']['downloads'] ?? [];

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
		<summary><?= $value == 'descarga' ? Language('download') : Language('stream') ?></summary>
		<section class="flex-column">
			<?php for($i_local = 1; $i_local <= $anime_mirando['cantidad_servidor_' . $value]; $i_local++){
				echo pSelect(['name'=> 'servidor_'.$value.'_'.$i_local, 'texto'=> Language('server').':', 'option'=> $lista_servidores[$value]]).' '.
				pInput(['name'=>'servidor_'.$value.'_'.$i_local.'_enlace','type'=>'url','placeholder' => Language('link')]);
				echo $value == 'descarga' ?
					pInput(['name'=>'servidor_'.$value.'_'.$i_local.'_enlace_acortado','type'=>'url','placeholder'=>Language('shortened-link')]) : '';
			} ?>
		</section>
	</details>
<?php } ?>
<section class="flex-between">
	<?= pInput(['name'=>'cantidad_servidor_stream','type'=>'number','min'=>1,'class'=>'campo form-campo-pequeno','placeholder'=>'1','label'=>true,'texto'=>Language('stream'),'value'=>$anime_mirando['cantidad_servidor_stream'],'required'=>true]) ?>
	<?= pInput(['name'=>'cantidad_servidor_descarga','type'=>'number','min'=>1,'class'=>'campo form-campo-pequeno','placeholder'=>'1','label'=>true,'texto'=>Language('download'),'value'=>$anime_mirando['cantidad_servidor_descarga'],'required'=>true]) ?>
	<?= pInput(['name'=>'episodio','type'=>'number','min'=>0,'value'=>1,'class'=>'campo form-campo-pequeno','placeholder'=>'1','label'=>true,'texto'=>Language('episode'),'required'=>true]) ?>
</section>