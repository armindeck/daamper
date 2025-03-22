<?= pInput(['name' => 'titulo', 'type' => 'text', 'placeholder' => 'Nombre del juego', 'label' => false, 'texto' => 'Nombre del juego', 'required' => true]) ?>
<?= pTextarea(['name' => 'sinopsis', 'placeholder' => 'Sinopsis', 'label' => false, 'texto' => 'Sinopsis', 'style' => 'min-height: 100px', 'required' => true]) ?>
<details>
	<summary>Opcionales</summary>
	<section class="flex-column">
		<?= pTextarea(['name' => 'otros_nombres', 'placeholder' => 'My Game Run, Mi Juego de Correr...', 'label' => true, 'texto' => 'Otros nombres', 'style' => 'min-height: 50px']) ?>
		<?= pTextarea(['name' => 'informacion_extra', 'placeholder' => 'Si el juego no les funciona... ya que a veces... ademas el codigo es...', 'label' => true, 'texto' => 'Información extra', 'style' => 'min-height: 100px']) ?>
	</section>
</details>
<?php require __DIR__ . '/scripts.php'; ?>
<?php foreach (['os' => $lista_os, 'categoria' => $lista_categorias] as $key => $lista): ?>
	<details>
		<summary><?= $key == 'os' ? 'Sistemas operativos' : 'Categorias' ?></summary>
		<section>
			<?php foreach ($lista as $opcion) {
				echo pCheckboxBoton(['nameidclass' => $key . "_" . SCRIPTS->archivoAceptado($opcion), 'texto' => $opcion]) . ' ';
			} ?>
		</section>
	</details>
<?php endforeach; ?>
<details>
	<summary>Imagenes</summary>
	<section>
		<?= pEnlace(['class' => '', 'texto' => 'Subir imagen', 'icono' => 'fas fa-external-link-alt', 'target' => '_blank', 'href' => '?ap=subir_imagen']) ?>
		<section style="margin-top: 4px; margin-bottom: 4px;">
			<?= pSelectArchivos(['name' => 'miniatura', 'label' => true, 'texto' => 'Miniatura', 'ruta' => $Web['directorio'] . 'assets/img/', 'tipo_archivos' => 'png,jpg,jpeg,gif']) ?>
			<?= pInput(['name' => 'miniatura_url', 'type' => 'url', 'placeholder' => 'Miniatura URL (opcional)', 'label' => false, 'texto' => 'Miniatura URL']) ?>
		</section>
		<section style="margin-bottom: 4px;">
			<?= pSelectArchivos(['name' => 'poster', 'label' => true, 'texto' => 'Poster', 'ruta' => $Web['directorio'] . 'assets/img/', 'tipo_archivos' => 'png,jpg,jpeg,gif']) ?>
			<?= pInput(['name' => 'poster_url', 'type' => 'url', 'placeholder' => 'Poster URL (opcional)', 'label' => false, 'texto' => 'Poster URL']) ?>
		</section>
		<section style="margin-bottom: 4px;">
			<?= pSelectArchivos(['name' => 'banner', 'label' => true, 'texto' => 'Banner', 'ruta' => $Web['directorio'] . 'assets/img/', 'tipo_archivos' => 'png,jpg,jpeg,gif']) ?>
			<?= pInput(['name' => 'banner_url', 'type' => 'url', 'placeholder' => 'Banner URL (opcional)', 'label' => false, 'texto' => 'Banner URL']) ?>
		</section>
		<details>
			<summary>Galeria</summary>
			<section class="flex-column">
				<?= pInput(['name' => 'galeria_cantidad', 'type' => 'number', 'placeholder' => '3', 'label' => true, 'texto' => 'Cantidad', 'min' => 1, 'max' => 50, 'value' => 4, 'class_label' => 'flex-between', 'required' => true]) ?>
				<?php for ($i_local = 1; $i_local <= ($_SESSION['tmpForm']['galeria_cantidad'] ?? 4); $i_local++): ?>
					<section>
						<?= pSelectArchivos(['name' => "galeria_{$i_local}", 'label' => true, 'texto' => 'Imagen', 'ruta' => $Web['directorio'] . 'assets/img/', 'tipo_archivos' => 'png,jpg,jpeg,gif']) ?>
						<?= pInput(['name' => "galeria_{$i_local}_url", 'type' => 'url', 'placeholder' => 'Imagen URL (opcional)', 'label' => false, 'texto' => 'Imagen URL']) ?>
					</section>
				<?php endfor;
				?>
			</section>
		</details>
	</section>
</details>
<details>
	<summary>Extras</summary>
	<section>
		<section style="margin-bottom: 4px;">
			<?= pInput(['name' => 'idiomas', 'label' => true, 'texto' => 'Idiomas', 'placeholder' => 'Español, Ingles, Japones, Chino, Coreano...', 'class_label' => 'flex-column', 'required' => true]) ?>
			<?= pInput(['name' => 'subtitulos', 'label' => true, 'texto' => 'Subtitulos', 'placeholder' => 'Español, Ingles, Japones, Chino, Coreano...', 'class_label' => 'flex-column',]) ?>
			<?= pInput(['name' => 'desarrollador', 'label' => true, 'texto' => 'Desarrollador', 'placeholder' => 'Desarrollador', 'class_label' => 'flex-column', 'style' => 'margin-bottom: 10px;']) ?>
			<?= pSelect([
				'name' => 'estado',
				'label' => true,
				'texto' => 'Estado',
				'value' => 'Desarrollo',
				'option' => [
					'Desarrollo',
					'Terminado',
					'Suspendido'
				]
			]) ?>
			<?= pInput(['name' => 'lanzado', 'type' => 'date', 'placeholder' => 'Lanzado', 'label' => true, 'texto' => 'Lanzado', 'required' => true]) ?>
			<?= pInput(['name' => 'terminado', 'type' => 'date', 'placeholder' => 'Terminado', 'label' => true, 'texto' => 'Terminado']) ?>
		</section>
		<section style="margin-bottom: 4px;">
			<?= pInput(['name' => 'version', 'class' => 'campo form-campo-mediano', 'placeholder' => '0.1.0', 'label' => true, 'texto' => 'Versión']) ?>
			<?= pSelect(['name' => "version_estado", 'label' => false, 'texto' => 'Estado', 'option' => ['Demo', 'Beta', 'Estable', "Preliminar", 'Lite', 'Pro']]) ?>
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
			<summary>Requisitos <?= ucfirst($value) ?>s</summary>
			<section>
				<section style="margin-bottom: 4px;">
					<?php foreach ($lista_os_requisitos as $os): $os_name = SCRIPTS->archivoAceptado($os);
						if (isset($_SESSION['tmpForm']["os_{$os_name}"]) && !empty($_SESSION['tmpForm']["os_{$os_name}"])) : ?>
							<details>
								<summary><?= $os ?></summary>
								<section>
									<?= pInput(['name' => "requisito_{$value}_os_{$os_name}_version", 'label' => true, 'texto' => "Versión/es", 'placeholder' => $os_name == 'android' ? '4, 5, 6, 7, 8, 9, 10, 11...' : ('XP/7/9/10/11'), 'class_label' => 'flex-column']) ?>
									<?= pInput(['name' => "requisito_{$value}_os_{$os_name}_procesador", 'label' => true, 'texto' => 'Procesador', 'placeholder' => $os_name == 'android' ? 'Hisilicon Kirin 710' : 'Intel Pentium 4 3.0GHz', 'class_label' => 'flex-column']) ?>
									<?= pInput(['name' => "requisito_{$value}_os_{$os_name}_targeta_grafica", 'label' => true, 'texto' => 'Targeta grafica <small>(Opcional)</small>', 'placeholder' => 'Nvidia Geforce', 'class_label' => 'flex-column', 'style' => 'margin-bottom: 10px;']) ?>
									<?= pInput(['name' => "requisito_{$value}_os_{$os_name}_ram", 'label' => true, 'texto' => 'Ram', 'type' => 'number', 'min' => 0, 'max' => 1000, 'placeholder' => '500']) ?>
									<?= pSelect(['name' => "requisito_{$value}_os_{$os_name}_ram_mb_or_gb", 'label' => false, 'texto' => 'MB o GB', 'option' => ['MB', 'GB']]) ?>
									<?= pInput(['name' => "requisito_{$value}_os_{$os_name}_espacio", 'label' => true, 'texto' => 'Espacio', 'min' => 0, 'max' => 1000, 'placeholder' => '500']) ?>
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
	<summary>Descargas</summary>
	<section>
		<section>
			<?php foreach ($lista_os as $os): $os_name = SCRIPTS->archivoAceptado($os);
				if (isset($_SESSION['tmpForm']["os_{$os_name}"]) && !empty($_SESSION['tmpForm']["os_{$os_name}"])) : ?>
					<details>
						<summary><?= $os ?></summary>
						<section class="flex-column">
							<?= pInput(['name' => "descarga_cantidad_os_{$os_name}", 'type' => 'number', 'label' => true, 'texto' => "Cantidad", 'placeholder' => 0, 'class' => 'campo form-campo-pequeno', 'class_label' => 'flex-between']) ?>
							<?php for ($i_local = 1; $i_local <= ($_SESSION['tmpForm']["descarga_cantidad_os_{$os_name}"] ?? 1); $i_local++): ?>
								<section class="flex-between">
									<section>
										<?= pInput(['name' => "descarga_version_{$i_local}_{$os_name}", 'placeholder' => '0.1.0', 'label' => false, 'texto' => 'Versión', 'class' => 'form-campo-pequeno', 'title' => 'Versión. Por defecto se usa la principal.']) ?>
										<?= pInput(['name' => "descarga_peso_{$i_local}_{$os_name}", 'label' => false, 'title' => 'Peso.', 'texto' => 'Peso', 'class' => 'form-campo-pequeno', 'placeholder' => '500']) ?>
										<?= pSelect(['name' => "descarga_peso_{$i_local}_{$os_name}_mb_or_gb", 'label' => false, 'texto' => 'MB o GB', 'option' => ['MB', 'GB']]) ?>
									</section>
									<section>
										<?= pSelect(['name' => "descarga_servidor_{$i_local}_{$os_name}", 'label' => false, 'texto' => 'Servidor', 'option' => $lista_servidor_descargas]) ?>
										<?= pInput(['name' => "descarga_enlace_acortado_{$i_local}_{$os_name}", 'type' => 'url', 'placeholder' => 'Enlace acortado', 'label' => false, 'texto' => 'Enlace acortado']) ?>
										<?= pInput(['name' => "descarga_enlace_directo_{$i_local}_{$os_name}", 'type' => 'url', 'placeholder' => 'Enlace directo', 'label' => false, 'texto' => 'Enlace directo']) ?>
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
	'texto' => 'Ruta',
	'value' => 'juego',
	'option' => [
		'juego/' => 'Juego/',
		'game/' => 'Game/'
	]
]) ?>
<?= pInput(['name' => 'archivo', 'placeholder' => 'Archivo', 'style' => 'width: 100%;', 'label' => false, 'texto' => 'Archivo', 'title' => 'Ruta de la publicación.', 'minlength' => 1, 'required' => true]) ?>