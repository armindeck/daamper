<?= pTextarea(['name'=>'sinopsis','placeholder'=>Language(['synopsis']),'label'=>false,'texto'=>Language(['synopsis']),'style'=>'min-height:100px','required'=>true]) ?>
<details>
	<summary><?= Language('categories') ?></summary>
	<section>
		<?php require RAIZ . "app/actions/admin/content/global/creators/script/anime_entrada.php";
		foreach ($lista_categorias as $key => $value) {
			echo pCheckboxBoton(['name' => $key, 'id'=> "input-check-".SCRIPTS->archivoAceptado($value), 'texto'=>$value]).' ';
		} ?>
	</section>
</details>
<details>
	<summary><?= Language('images') ?></summary>
	<section>
		<?= pEnlace(['class'=>'', 'texto'=>Language('upload-image'),'icono'=>'fas fa-external-link-alt','target'=>'_blank','href'=>'?ap=subir_imagen']) ?>
		<section style="margin-top: 4px; margin-bottom: 4px;">
			<?= pSelectArchivos(['name'=>'miniatura','label'=>true,'texto'=>Language('thumbnail'),'ruta'=>$Web['directorio'].'assets/img/','tipo_archivos'=>'png,jpg,jpeg,gif']) ?>
			<?= pInput(['name'=>'miniatura_url','type'=>'url','placeholder'=>Language('thumbnail').' URL ('.(Language('optional')).')','label'=>false,'texto'=>Language('thumbnail').' URL']) ?>
		</section>
		<section style="margin-bottom: 4px;">
			<?= pSelectArchivos(['name'=>'poster','label'=>true,'texto'=>Language('poster'),'ruta'=>$Web['directorio'].'assets/img/','tipo_archivos'=>'png,jpg,jpeg,gif']) ?>
			<?= pInput(['name'=>'poster_url','type'=>'url','placeholder'=>Language('poster').' URL ('.(Language('optional')).')','label'=>false,'texto'=>Language('poster').' URL']) ?>
		</section>
		<?= pSelectArchivos(['name'=>'banner','label'=>true,'texto'=>Language('banner'),'ruta'=>$Web['directorio'].'assets/img/','tipo_archivos'=>'png,jpg,jpeg,gif']) ?>
		<?= pInput(['name'=>'banner_url','type'=>'url','placeholder'=>Language('banner').' URL ('.(Language('optional')).')','label'=>false,'texto'=>Language('banner').' URL']) ?>
	</section>
</details>
<details>
	<summary><?= Language('extras') ?></summary>
	<section>
		<section style="margin-bottom: 4px;">
			<?= pSelect(['name'=>'idioma','label'=>true,'texto'=>Language('language'),'value'=>'japanese','option'=>
				[
				'japanese' => Language('japanese'),
				'spanish' => Language('spanish'),
				'english' => Language('english'),
				'chinese' => Language('chinese'),
				'castilian' => Language('castilian')
				]
			]) ?>
			<?= pSelect(['name'=>'subtitulo','label'=>true,'texto'=>Language('subtitle'),'value'=>'spanish','option'=>
				[
					'japanese' => Language('japanese'),
					'spanish' => Language('spanish'),
					'english' => Language('english'),
					'chinese' => Language('chinese'),
					'castilian' => Language('castilian'),
					''
				]
			]) ?>
			<?= pSelect(['name'=>'estado','label'=>true,'texto'=>Language('state'),'value'=>'airing','option'=>
				[
				'airing' => Language('airing'),
				'finalized' => Language('finalized'),
				'suspended' => Language('suspended')
				]
			]) ?>
		</section>
		<section style="margin-bottom: 4px;">
			<?= pInput(['name'=>'episodios','type'=>'number','min'=>0,'class'=>'campo form-campo-pequeno','placeholder'=>'1','label'=>true,'texto'=>Language('episodes'),'required'=>true]) ?>
			<?= pSelect(['name'=>'episodios_cada','label'=>true,'texto'=>Language('every'),'option'=>
				[
				'monday' => Language('monday'),
				'tuesday' => Language('tuesday'),
				'wednesday' => Language('wednesday'),
				'thursday' => Language('thursday'),
				'friday' => Language('friday'),
				'saturday' => Language('saturday'),
				'sunday' => Language('sunday'),
				'undefined' => Language('undefined')
				]
			]) ?>
		</section>
		<section style="margin-bottom: 4px;">
			<?= pInput(['name'=>'estreno','type'=>'date','placeholder'=>Language('premiere'),'label'=>true,'texto'=>Language('premiere'),'required'=>true]) ?>
			<?= pInput(['name'=>'finalizo','type'=>'date','placeholder'=>Language('ended'),'label'=>true,'texto'=>Language('ended')]) ?>
		</section>
		<?= pSelect(['name'=>'catalogo','label'=>true,'texto'=>Language('catalog'),'value'=>'anime','option'=>
			[
			'anime' => Language('anime'),
			'hentai' => Language('hentai'),
			'movie' => Language('movie'),
			'ova' => Language('ova')
			]
		]) ?>
	</section>
</details>
<?= pSelect(['name'=>'ruta','label'=>false,'style'=>'width: 100%;', 'texto'=>Language('route'),'value'=>'anime','option'=>[
	'anime/' => 'Anime/', 'hentai/' => 'Hentai/']
]) ?>
<?= pInput(['name'=>'archivo','placeholder'=>Language('file'),'style'=>'width: 100%;','label'=>false,'texto'=>Language('file'),'title'=>Language('post-route'),'minlength'=>1,'required'=>true]) ?>