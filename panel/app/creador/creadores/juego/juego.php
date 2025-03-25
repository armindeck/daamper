<?= pInput(['name' => 'titulo', 'type' => 'text', 'placeholder' => Language(['creador', 'name-of-the-game'], 'dashboard'), 'label' => false, 'texto' => Language(['creador', 'name-of-the-game'], 'dashboard'), 'required' => true]) ?>
<?= pTextarea(['name' => 'sinopsis', 'placeholder' => Language('synopsis'), 'label' => false, 'texto' => Language('synopsis'), 'style' => 'min-height: 100px', 'required' => true]) ?>
<details>
	<summary><?= Language('optional') ?></summary>
	<section class="flex-column">
		<?= pTextarea(['name' => 'otros_nombres', 'placeholder' => 'My Game Run, ShooterSpaces...', 'label' => true, 'texto' => Language('other-names'), 'style' => 'min-height: 50px']) ?>
		<?= pTextarea(['name' => 'informacion_extra', 'placeholder' => Language(['creador', 'other', 'juego', 'extra-information-placeholder'], 'dashboard'), 'label' => true, 'texto' => Language('extra-information'), 'style' => 'min-height: 100px']) ?>
	</section>
</details>
<?php require __DIR__ . '/scripts.php'; ?>
<?php foreach (['os' => $lista_os, 'categoria' => $lista_categorias] as $key => $lista): ?>
	<details>
		<summary><?= $key == 'os' ? Language('operating-systems') : Language('categories') ?></summary>
		<section>
			<?php foreach ($lista as $opcion) {
				echo pCheckboxBoton(['nameidclass' => $key . "_" . SCRIPTS->archivoAceptado($opcion), 'texto' => $opcion]) . ' ';
			} ?>
		</section>
	</details>
<?php endforeach; ?>
<details>
	<summary><?= Language('images') ?></summary>
	<section>
		<?= pEnlace(['class' => '', 'texto' => Language('upload-image'), 'icono' => 'fas fa-external-link-alt', 'target' => '_blank', 'href' => '?ap=subir_imagen']) ?>
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
		<details>
			<summary><?= Language('gallery') ?></summary>
			<section class="flex-column">
				<?= pInput(['name' => 'galeria_cantidad', 'type' => 'number', 'placeholder' => '3', 'label' => true, 'texto' => Language('quantity'), 'min' => 1, 'max' => 50, 'value' => 4, 'class_label' => 'flex-between', 'required' => true]) ?>
				<?php for ($i_local = 1; $i_local <= ($_SESSION['tmpForm']['galeria_cantidad'] ?? 4); $i_local++): ?>
					<section>
						<?= pSelectArchivos(['name' => "galeria_{$i_local}", 'label' => true, 'texto' => Language('image'), 'ruta' => $Web['directorio'] . 'assets/img/', 'tipo_archivos' => 'png,jpg,jpeg,gif']) ?>
						<?= pInput(['name' => "galeria_{$i_local}_url", 'type' => 'url', 'placeholder' => Language('image').' URL ('.(Language('optional')).')', 'label' => false, 'texto' => Language('image').' URL']) ?>
					</section>
				<?php endfor;
				?>
			</section>
		</details>
	</section>
</details>
<details>
	<summary><?= Language('extras') ?></summary>
	<section>
		<section style="margin-bottom: 4px;">
			<?= pInput(['name' => 'idiomas', 'label' => true, 'texto' => Language('languages'), 'placeholder' => 'Español, Ingles, Japones, Chino, Coreano...', 'class_label' => 'flex-column', 'required' => true]) ?>
			<?= pInput(['name' => 'subtitulos', 'label' => true, 'texto' => Language('subtitles'), 'placeholder' => 'Español, Ingles, Japones, Chino, Coreano...', 'class_label' => 'flex-column',]) ?>
			<?= pInput(['name' => 'desarrollador', 'label' => true, 'texto' => Language('developer'), 'placeholder' => Language('developer'), 'class_label' => 'flex-column', 'style' => 'margin-bottom: 10px;']) ?>
			<?= pSelect([
				'name' => 'estado',
				'label' => true,
				'texto' => Language('state'),
				'value' => 'development',
				'option' => [
					'development' => Language('development'),
					'completed' => Language('completed'),
					'suspended' => Language('suspended')
				]
			]) ?>
			<?= pInput(['name' => 'lanzado', 'type' => 'date', 'placeholder' => Language('released'), 'label' => true, 'texto' => Language('released'), 'required' => true]) ?>
			<?= pInput(['name' => 'terminado', 'type' => 'date', 'placeholder' => Language('completed'), 'label' => true, 'texto' => Language('completed')]) ?>
		</section>
		<section style="margin-bottom: 4px;">
			<?= pInput(['name' => 'version', 'class' => 'campo form-campo-mediano', 'placeholder' => '0.1.0', 'label' => true, 'texto' => Language('version')]) ?>
			<?= pSelect(['name' => "version_estado", 'label' => false, 'texto' => Language('state'), 'option' => $lista_estados]) ?>
		</section>
	</section>
</details>
<?php foreach ($lista_os_requisitos as $os) {
	$os_name = SCRIPTS->archivoAceptado($os);
	if (isset($_SESSION['tmpForm']['os_' . $os_name]) && !empty($_SESSION['tmpForm']['os_' . $os_name])) {
		$mostrar_requisitos = true;
		break;
	}
}
if (isset($mostrar_requisitos)): ?>
	<?php foreach (['minimo', "recomendado"] as $value): ?>
		<details>
			<summary><?= Language($value == 'minimo' ? 'minimum-requirements' : 'recommended-requirements') ?></summary>
			<section>
				<section style="margin-bottom: 4px;">
					<?php foreach ($lista_os_requisitos as $os): $os_name = SCRIPTS->archivoAceptado($os);
						if (isset($_SESSION['tmpForm']["os_{$os_name}"]) && !empty($_SESSION['tmpForm']["os_{$os_name}"])) : ?>
							<details>
								<summary><?= $os ?></summary>
								<section>
									<?= pInput(['name' => "requisito_{$value}_os_{$os_name}_version", 'label' => true, 'texto' => Language('versions'), 'placeholder' => $os_name == 'android' ? '4, 5, 6, 7, 8, 9, 10, 11...' : ('XP/7/9/10/11'), 'class_label' => 'flex-column']) ?>
									<?= pInput(['name' => "requisito_{$value}_os_{$os_name}_procesador", 'label' => true, 'texto' => Language('proccesor'), 'placeholder' => $os_name == 'android' ? 'Hisilicon Kirin 710' : 'Intel Pentium 4 3.0GHz', 'class_label' => 'flex-column']) ?>
									<?= pInput(['name' => "requisito_{$value}_os_{$os_name}_targeta_grafica", 'label' => true, 'texto' => Language('graphics-card').' <small>('.(Language('optional')).')</small>', 'placeholder' => 'Nvidia Geforce', 'class_label' => 'flex-column', 'style' => 'margin-bottom: 10px;']) ?>
									<?= pInput(['name' => "requisito_{$value}_os_{$os_name}_ram", 'label' => true, 'texto' => Language('ram'), 'type' => 'number', 'min' => 0, 'max' => 1000, 'placeholder' => '500']) ?>
									<?= pSelect(['name' => "requisito_{$value}_os_{$os_name}_ram_mb_or_gb", 'label' => false, 'texto' => 'MB o GB', 'option' => ['MB', 'GB']]) ?>
									<?= pInput(['name' => "requisito_{$value}_os_{$os_name}_espacio", 'label' => true, 'texto' => Language('storage'), 'min' => 0, 'max' => 1000, 'placeholder' => '500', 'class' => 'campo form-campo-pequeno']) ?>
									<?= pSelect(['name' => "requisito_{$value}_os_{$os_name}_espacio_mb_or_gb", 'label' => false, 'texto' => 'MB o GB', 'option' => ['MB', 'GB']]) ?>
								</section>
							</details>
							<?php endif; ?><?php endforeach; ?>
				</section>
			</section>
		</details>
	<?php endforeach; ?>
<?php endif; ?>
<details>
	<summary><?= Language('downloads') ?></summary>
	<section>
		<section>
			<?php foreach ($lista_os as $os): $os_name = SCRIPTS->archivoAceptado($os);
				if (isset($_SESSION['tmpForm']["os_{$os_name}"]) && !empty($_SESSION['tmpForm']["os_{$os_name}"])) : ?>
					<details>
						<summary><?= $os ?></summary>
						<section class="flex-column">
							<?= pInput(['name' => "descarga_cantidad_os_{$os_name}", 'type' => 'number', 'label' => true, 'texto' => Language('quantity'), 'placeholder' => 0, 'class' => 'campo form-campo-pequeno', 'class_label' => 'flex-between']) ?>
							<?php for ($i_local = 1; $i_local <= ($_SESSION['tmpForm']["descarga_cantidad_os_{$os_name}"] ?? 1); $i_local++): ?>
								<section class="flex-between">
									<section>
										<?= pInput(['name' => "descarga_version_{$i_local}_{$os_name}", 'placeholder' => '0.1.0', 'label' => false, 'texto' => Language('version'), 'class' => 'form-campo-pequeno', 'title' => Language(['creador', 'other', 'juego', 'default-used-main'], 'dashboard')]) ?>
										<?= pInput(['name' => "descarga_peso_{$i_local}_{$os_name}", 'label' => false, 'title' => Language('size'), 'texto' => Language('size'), 'class' => 'form-campo-pequeno', 'placeholder' => '500']) ?>
										<?= pSelect(['name' => "descarga_peso_{$i_local}_{$os_name}_mb_or_gb", 'label' => false, 'texto' => 'MB o GB', 'option' => ['MB', 'GB']]) ?>
									</section>
									<section>
										<?= pSelect(['name' => "descarga_servidor_{$i_local}_{$os_name}", 'label' => false, 'texto' => Language('server'), 'option' => Database('creator/list')['server-downloads']]) ?>
										<?= pInput(['name' => "descarga_enlace_directo_{$i_local}_{$os_name}", 'type' => 'url', 'placeholder' => Language('link'), 'label' => false, 'texto' => Language('link')]) ?>
										<?= pInput(['name' => "descarga_enlace_acortado_{$i_local}_{$os_name}", 'type' => 'url', 'placeholder' => Language('shortened-link'), 'label' => false, 'texto' => Language('shortened-link')]) ?>
									</section>
								</section>
							<?php endfor;
							?>
						</section>
					</details>
					<?php endif; ?><?php endforeach; ?>
		</section>
	</section>
</details>
<?= pSelect([
	'name' => 'ruta',
	'label' => false,
	'style' => 'width: 100%;',
	'texto' => Language('route'),
	'value' => 'juego',
	'option' => [
		'juego/' => 'juego/',
		'game/' => 'game/'
	]
]) ?>
<?= pInput(['name' => 'archivo', 'placeholder' => Language('file'), 'style' => 'width: 100%;', 'label' => false, 'texto' => Language('file'), 'title' => Language('post-route'), 'minlength' => 1, 'required' => true]) ?>