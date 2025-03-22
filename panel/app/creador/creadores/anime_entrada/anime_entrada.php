<?= pTextarea(['name'=>'sinopsis','placeholder'=>'Sinopsis','label'=>false,'texto'=>'Sinopsis:','style'=>'min-height:100px','required'=>true]) ?>
<details>
	<summary>Categorias</summary>
	<section>
		<?php require __DIR__.'/scripts.php';
		foreach ($lista_categorias as $key => $value) {
			echo pCheckboxBoton(['nameidclass'=>SCRIPTS->archivoAceptado($value),'texto'=>$value]).' ';
		} ?>
	</section>
</details>
<details>
	<summary>Imagenes</summary>
	<section>
		<?= pEnlace(['class'=>'', 'texto'=>'Subir imagen','icono'=>'fas fa-external-link-alt','target'=>'_blank','href'=>'?ap=subir_imagen']) ?>
		<section style="margin-top: 4px; margin-bottom: 4px;">
			<?= pSelectArchivos(['name'=>'miniatura','label'=>true,'texto'=>'Miniatura','ruta'=>$Web['directorio'].'assets/img/','tipo_archivos'=>'png,jpg,jpeg,gif']) ?>
			<?= pInput(['name'=>'miniatura_url','type'=>'url','placeholder'=>'Miniatura URL (opcional)','label'=>false,'texto'=>'Miniatura URL']) ?>
		</section>
		<section style="margin-bottom: 4px;">
			<?= pSelectArchivos(['name'=>'poster','label'=>true,'texto'=>'Poster','ruta'=>$Web['directorio'].'assets/img/','tipo_archivos'=>'png,jpg,jpeg,gif']) ?>
			<?= pInput(['name'=>'poster_url','type'=>'url','placeholder'=>'Poster URL (opcional)','label'=>false,'texto'=>'Poster URL']) ?>
		</section>
		<?= pSelectArchivos(['name'=>'banner','label'=>true,'texto'=>'Banner','ruta'=>$Web['directorio'].'assets/img/','tipo_archivos'=>'png,jpg,jpeg,gif']) ?>
		<?= pInput(['name'=>'banner_url','type'=>'url','placeholder'=>'Banner URL (opcional)','label'=>false,'texto'=>'Banner URL']) ?>
	</section>
</details>
<details>
	<summary>Extras</summary>
	<section>
		<section style="margin-bottom: 4px;">
			<?= pSelect(['name'=>'idioma','label'=>true,'texto'=>'Idioma','value'=>'Japones','option'=>[
				'Japones','Español','Ingles','Chino','Castellano']
			]) ?>
			<?= pSelect(['name'=>'subtitulo','label'=>true,'texto'=>'Subtitulo','value'=>'Español','option'=>['Español','Ingles','']
			]) ?>
			<?= pSelect(['name'=>'estado','label'=>true,'texto'=>'Estado','value'=>'Emisión','option'=>[
				'Emisión','Finalizado','Suspendido']
			]) ?>
		</section>
		<section style="margin-bottom: 4px;">
			<?= pInput(['name'=>'episodios','type'=>'number','min'=>0,'class'=>'campo form-campo-pequeno','placeholder'=>'1','label'=>true,'texto'=>'Episodios','required'=>true]) ?>
			<?= pSelect(['name'=>'episodios_cada','label'=>true,'texto'=>'Cada','option'=>[
				'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo','Indefinido']
			]) ?>
		</section>
		<section style="margin-bottom: 4px;">
			<?= pInput(['name'=>'estreno','type'=>'date','placeholder'=>'Estreno','label'=>true,'texto'=>'Estreno','required'=>true]) ?>
			<?= pInput(['name'=>'finalizo','type'=>'date','placeholder'=>'Finalizo','label'=>true,'texto'=>'Finalizo']) ?>
		</section>
		<?= pSelect(['name'=>'catalogo','label'=>true,'texto'=>'Catalogo','value'=>'Anime','option'=>['Anime','Hentai','Pelicula','Ova']]) ?>
	</section>
</details>
<?= pSelect(['name'=>'ruta','label'=>false,'style'=>'width: 100%;', 'texto'=>'Ruta','value'=>'anime','option'=>[
	'anime/' => 'Anime/', 'hentai/' => 'Hentai/']
]) ?>
<?= pInput(['name'=>'archivo','placeholder'=>'Archivo','style'=>'width: 100%;','label'=>false,'texto'=>'Archivo','title'=>'Ruta de la publicación.','minlength'=>1,'required'=>true]) ?>