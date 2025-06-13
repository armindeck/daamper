<?php global $Global, $Creador; ?>
<?php $ruta = [
	['titulo' => 'publish', 'archivos' => glob(__DIR__ . '/creators/*')],
	['titulo' => 'posts', 'archivos' => glob(RAIZ . "database/post/*.json")],
	['titulo' => 'drafts', 'archivos' => glob(RAIZ . "database/draft/*.json")],
]; ?>
<section class="panel">
	<section class="form">
		<section><small><?= Language(['creator', 'message'], 'dashboard') ?></small></section>
		<details <?= !isset($_GET['creador']) ? 'open' : '' ?>>
			<summary><?= Language(['creator', 'actions'], 'dashboard') ?></summary>
			<?php foreach ($ruta as $elemento) {
				sort($elemento['archivos'], SORT_NATURAL | SORT_FLAG_CASE); ?>
				<details>
					<summary><?= Language(['creator', $elemento['titulo']], 'dashboard') ?></summary>
					<section class="flex-column botones-2 botones-mini">
						<?php foreach ($elemento['archivos'] as $archivo) {
							echo '<a ';
							echo isset($_GET['creador']) && $_GET['creador'] == basename($archivo) || isset($_GET['archivo']) && $_GET['archivo'] == basename($archivo) ? 'style="color: var(--a-hover-co);"' : '';
							echo ' href="?ap=creator&creador=' . ($elemento['titulo'] == 'publish' ? str_replace("-view.php", "", basename($archivo)) : 'normal&tipo=' . ($elemento['titulo'] == 'posts' ? 'publicacion' : 'borrador') . '&archivo=' . basename($archivo)) . '">' . (str_replace(["-view.php", "pu_", "bo_", ".php", ".json"], "", basename($archivo))) . '</a>';
						} ?>
					</section>
				</details>
			<?php } ?>
			<details>
				<summary><?= Language(['creator', 'entries'], 'dashboard') ?></summary>
				<?php if (!isset($_GET['creador']) && !isset($_GET['disable-entries'])){ ?>
					<form method="get">
						<p class="t-center" style="background-color: rgb(0,0,0,.3); padding: 2px 6px 2px 6px; margin-bottom: 4px;"><?= Language(['creator', 'attention-update'], 'dashboard') ?></p>
						<label class="flex-between">
							<span><?= Language('quantity') ?>:</span>
							<input type="text" name="ap" value="creator" hidden required>
							<?php $p = file_exists(RAIZ . 'database/creator/list-of-entries.json') ? DATA->Read("creator/list-of-entries") : []; ?>
							<?= pInput(['class' => 'form-campo-pequeno', 'placeholder' => 1, 'type' => 'number', 'min' => 0, 'max' => 99, 'name' => 'cantidad-entradas', 'value' => (isset($_GET['cantidad-entradas']) ? SCRIPTS->normalizar2($_GET['cantidad-entradas']) : (isset($p) ? count($p) : 1))]) ?>
						</label>
						<details open>
							<summary><?= Language(['creator', 'list-of-entries'], 'dashboard') ?></summary>
							<section class="flex-between">
								<?php for ($j = 0; $j < (isset($_GET['cantidad-entradas']) ? SCRIPTS->normalizar2($_GET['cantidad-entradas']) : count($p)); $j++) { ?>
									<section>
										<input type="text" name="entrada-<?= $j ?>" value="<?= $p[$j]['entrada'] ?? '' ?>" placeholder="<?= !$j ? Language(['creator', 'do-not-touch-this-field'], 'dashboard') : 'Post' ?>" title="<?= !$j ? Language(['creator', 'do-not-touch-this-field'], 'dashboard') : 'blog / post / juego / web / ...' ?>">
										<?= pCheckboxBoton(['name' => "entrada-poster-$j", 'id' => "entrada-poster-$j", 'icono' => 'fas fa-eye', 'title' => Language(['creator', 'image-type-poster'], 'dashboard'), 'checked' => (isset($p[$j]['poster']) && !empty($p[$j]['poster']) ? true : false)]) ?>
										<details>
											<summary><?= Language('titles') ?></summary>
											<section class="flex-between">
												<input type="text" name="entrada-titulo-<?= $j ?>" value="<?= $p[$j]['titulo'] ?? '' ?>" placeholder="<?= Language('title') ?>" title="<?= Language('games') ?>">
												<input type="text" name="entrada-titulo-alternativo-<?= $j ?>" value="<?= $p[$j]['titulo-alternativo'] ?? '' ?>" placeholder="<?= Language(['creator', 'title-in-the-entries'], 'dashboard') ?>" title="<?= Language(['creator', 'the-best-games'], 'dashboard') ?>">
											</section>
										</details>
									</section>
								<?php } ?>
							</section>
						</details>
						<input class="boton boton-mini" style="margin-top: 8px;" type="submit" name="actualizar-entradas" value="<?= Language('update') ?>">
					</form>
				<?php } else { ?>
					<a href="?ap=creator" class="boton-2"><i class="fas fa-eye"></i> <?= Language("show") ?></a>
				<?php } ?>
				</details>
		</details>
	</section>
</section>
<?php if (isset($_GET['creador'])) {
	$Global['get_creador'] = SCRIPTS->normalizar2($_GET['creador']);
	$ruta_creador = __DIR__ . "/creators/{$Global['get_creador']}-view.php"; ?>
	<?= !file_exists($ruta_creador) ?
		"<section class='panel'><section class='form'><p>".(Language(['creator', 'creator-no-exists'], 'dashboard', ['value' => "<strong>{$Global['get_creador']}</strong>"]))."</p></section></section>" : '' ?>
	<?php if (file_exists($ruta_creador)) { ?>
		<form method="post" class="panel" style="gap: 8px;">
			<?php $files = glob("{$Web['directorio']}*");
			$directorios = [];
			foreach ($files as $file) {
				if (!is_file($file) && !in_array(basename($file), ['app', 'assets', 'auth', 'p', 'admin', 'process', 'database'])) {
					$directorios[basename($file) . '/'] = ucfirst(basename($file)) . '/';
				}
			}
			
			$ruta_campos_predeterminados = "database/creator/field-default.json";
			if (file_exists(RAIZ .  $ruta_campos_predeterminados)) {
				$Predeterminados = DATA->Read("creator/field-default")[$Global["get_creador"]];
			} else {
				echo "<section class='form t-center'><p>" . Language("file-no-exists", "global", ["value" => $ruta_campos_predeterminados]) . "</p></section>";
			}
			if (isset($Predeterminados)){
				for ($i = 1; $i <= 3; $i++) {
					if (!isset($Predeterminados['contenedor_predeterminado'][$i]) or isset($Predeterminados['contenedor_predeterminado'][$i]) && $Predeterminados['contenedor_predeterminado'][$i]) { ?>
						<section class="form" style="margin-top: 0; margin-bottom: 0;">
					<?php if ($i == 2) {
							echo '<strong>'.(Language('creator')).' ~ ' . $Global['get_creador'] . '</strong><hr>';
							require $ruta_creador;
						}
						if ($i == 1 || $i == 3) {
							#echo '<section>';
							$lista_campos_predeterminados[1] = [
								['name' => 'titulo', 'contenido' =>
								pInput(['name' => 'titulo', 'placeholder' => (Language('title')), 'label' => false, 'texto' => (Language('title')), 'required' => true])],
								['name' => 'descripcion', 'contenido' =>
								pInput(['name' => 'descripcion', 'placeholder' => (Language(['creator', 'description'], 'dashboard')), 'label' => false, 'texto' => (Language(['creator', 'description'], 'dashboard')), 'required' => true])],
								['name' => 'meta_descripcion', 'contenido' =>
								pInput(['name' => 'meta_descripcion', 'placeholder' => (Language(['creator', 'meta-description'], 'dashboard')), 'label' => false, 'texto' => (Language(['creator', 'meta-description'], 'dashboard')), 'required' => true])],
								['name' => 'catalogo', 'contenido' =>
								pInput(['name' => 'catalogo', 'placeholder' => (Language(['creator', 'catalog'], 'dashboard')), 'label' => false, 'texto' => (Language(['creator', 'catalog'], 'dashboard')), 'required' => true])],
								['name' => 'meta_etiquetas', 'contenido' =>
								pInput(['name' => 'meta_etiquetas', 'placeholder' => (Language(['creator', 'meta-tags'], 'dashboard')), 'label' => false, 'texto' => (Language(['creator', 'meta-tags'], 'dashboard')), 'required' => true])]
							];

							$lista_campos_predeterminados[3] = [
								['name' => 'a_subir_imagen', 'contenido' =>
								pEnlace(['class' => '', 'texto' => (Language('upload-image')), 'icono' => 'fas fa-external-link-alt', 'target' => '_blank', 'href' => '?ap=upload-image'])],
								['name' => 'miniatura', 'contenido' =>
								pSelectArchivos(['name' => 'miniatura', 'label' => true, 'texto' => (Language('thumbnail')), 'ruta' => $Web['directorio'] . 'assets/img/', 'tipo_archivos' => 'png,jpg,jpeg,gif'])],
								['name' => 'miniatura_url', 'contenido' =>
								pInput(['name' => 'miniatura_url', 'type' => 'url', 'placeholder' => (Language('thumbnail')) . ' URL ('.(Language('optional')).')', 'label' => false, 'texto' => (Language('thumbnail')) . ' URL']) . '<hr>'],
								['name' => 'anuncio', 'contenido' =>
								pCheckboxBoton(['nameidclass' => 'anuncio', 'texto' => (Language('announcement')), 'icono' => 'fas fa-newspaper', 'checked' => true])],
								['name' => 'privado', 'contenido' =>
								pCheckboxBoton(['nameidclass' => 'privado', 'texto' => (Language(['creator', 'private'], 'dashboard')), 'icono' => 'fas fa-eye-slash'])],
								['name' => 'comentar', 'contenido' =>
								pCheckboxBoton(['nameidclass' => 'comentar', 'texto' => (Language('comment')), 'icono' => 'fas fa-comment-alt', 'checked' => true])],
								['name' => 'comentarios', 'contenido' =>
								pCheckboxBoton(['nameidclass' => 'comentarios', 'texto' => (Language('comments')), 'icono' => 'fas fa-comments', 'checked' => true]) . '<hr>'],
								['name' => 'ruta', 'contenido' =>
								pInput(['name' => 'ruta', 'placeholder' => (Language('route')).'/', 'style' => 'width: 100%;', 'label' => false, 'texto' => (Language('route')), 'title' => (Language('post-route')), 'minlength' => 1])],
								['name' => 'archivo', 'contenido' =>
								pInput(['name' => 'archivo', 'placeholder' => (Language('file')), 'style' => 'width: 100%;', 'label' => false, 'texto' => (Language('file')), 'title' => (Language('file')), 'minlength' => 1, 'required' => true])]
							];

							foreach ($lista_campos_predeterminados[$i] as $value) {
								if (!isset($Predeterminados['campo_predeterminado'][$value['name']]) or isset($Predeterminados['campo_predeterminado'][$value['name']]) && $Predeterminados['campo_predeterminado'][$value['name']]) {
									echo $value['contenido'] . ($Predeterminados['campo_predeterminado'][$value['name']] !== true ? $Predeterminados['campo_predeterminado'][$value['name']] : ' ');
								}
							}
							if ($i == 3) {
								if (!isset($Predeterminados['campo_predeterminado']['mostrar_en_index']) or isset($Predeterminados['campo_predeterminado']['mostrar_en_index']) && $Predeterminados['campo_predeterminado']['mostrar_en_index']) {
									if (!file_exists(RAIZ . 'database/post/' . str_replace('bo_', '', $Global['get_archivo']))) {
										echo '<hr>' . pCheckboxBoton(['nameidclass' => 'mostrar_en_index', 'texto' => (Language(['creator', 'show-in-the-list'], 'dashboard')), 'icono' => 'fas fa-eye', 'checked' => true]);
									}
								}
							}
						}
						echo '</section>';
					}
				}
			} ?>
				<section class="form">
					<?php if (isset($_GET['tipo']) && isset($_GET['archivo'])) {
						if (in_array($_GET['tipo'], ['borrador', 'publicacion'])) {
							if (file_exists(RAIZ . 'database/post/' . str_replace('bo_', '', $Global['get_archivo']))) {
								echo '<section class="flex-between">' .
									pCheckboxBoton(['nameidclass' => 'volver_a_mostrarlo_como_nuevo', 'texto' => (Language(['creator', 'show-it-as-new'], 'dashboard')), 'icono' => 'fas fa-history', 'checked' => false]) .
									pCheckboxBoton(['nameidclass' => 'quitarlo_del_index', 'texto' => (Language(['creator', 'remove-it-from-the-list'], 'dashboard')), 'icono' => 'fas fa-times-circle', 'checked' => false]) .
									'</section><hr>';
							}
						}
					} ?>
					<section class="flex-between">
						<?= pInput(['type' => 'hidden', 'name' => 'creador', 'value' => $Global['get_creador'], 'des_session' => true]) ?>
						<?= pInput(['type' => 'hidden', 'name' => 'pubo', 'value' => $Global['get_tipo'], 'des_session' => true]) ?>
						<?= pInput(['type' => 'hidden', 'name' => 'db_archivo', 'value' => $Global['get_archivo'], 'des_session' => true]) ?>
						<?= pInput(['type' => 'submit', 'class' => 'boton2', 'name' => 'refrescar', 'value' => '&#xf021; '. Language('refresh'), 'des_session' => true]) ?>
						<?= pInput(['type' => 'submit', 'class' => 'boton', 'name' => 'mostrar', 'value' => Language('show'). ' &#xf06e;', 'des_session' => true]) ?>
					</section>
					<hr>
					<?= SCRIPTS->xv("creator"); ?>
				</section>
		</form>
<?php }
} ?>