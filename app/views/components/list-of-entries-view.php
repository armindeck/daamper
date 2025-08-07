<?php function listaContenido(string $archivo_publicaciones = 'posts', string $tipo = 'normal', string $opcion = '', array $lista = [], array $titulo = [], string $ruta = "")
{
	global $Web;
	$archivo_publicaciones = empty($archivo_publicaciones) ? "posts" : $archivo_publicaciones;
	$archivo_publicaciones = "database/post/entries/" . str_replace([".php", ".json"], "", $archivo_publicaciones) . ".json";
	if (file_exists(RAIZ . $archivo_publicaciones)) {
		$lista_publicaciones = Daamper::$data->Read($archivo_publicaciones) ?? [];
		if (!empty($lista_publicaciones)) {
			$titulos = empty($ruta) ? $titulo['titulo'] : $titulo['titulo-alternativo'];
			echo '<hr>';
			if (!empty($titulos)) {
				echo '<section class="con t-center">' . $titulos . '</section><hr>';
			}
			echo $tipo == 'normal' ? '<section class="index-entrada">' : '<section class="normal-directorio">';
			foreach (array_reverse($lista_publicaciones) as $archivo) {
				$archivo_json = str_replace(".php", "", $archivo) . ".json";
				$archivo_db = "database/post/$archivo_json";
				if (file_exists(RAIZ . $archivo_db)) {
					$ACR = Daamper::$data->Read($archivo_db)["ACR"];
					$AC = Daamper::$data->Read($archivo_db)["AC"];
					if ($tipo == 'normal'): ?>
						<a href="<?= $Web['directorio'] . $AC['ruta'] . str_replace(array('index', '.php'), '', $AC['archivo']) . (basename($AC['archivo']) == 'index.php' ? '' : $Web['config']['php']); ?>">
							<div class="con-entrada">
								<div class="catalogo">
									<p><?= isset($AC['catalogo']) ? $AC['catalogo'] : ($AC['episodio'] ?? ''); ?></p>
								</div>
								<div class="imagen">
									<img loading="lazy" src="<?= ImagenesACX($AC, true) ?>">
								</div>
								<div class="texto">
									<p><?php if (isset($AC['referencia']) && !empty($AC['referencia'])) {
											$AC = Daamper::$data->Post($AC['referencia'])["AC"];
										} ?>
										<?= $AC['titulo'] ?? ''; ?></p>
								</div>
							</div>
						</a>
					<?php endif; ?>
					<?php if ($tipo == 'poster'): ?>
						<div class="elemento">
							<a href="<?= $Web['directorio'] . $AC['ruta'] . Daamper::$scripts->quitarEPHP($AC['archivo']) . $Web['config']['php'] ?>">
								<div class="imagen">
									<img loading="lazy" src="<?= ImagenesACX($AC, $Web['directorio'] . Daamper::imgPath('logo.png')) ?>" alt="<?= Language('poster-of', 'global', ['value' => $AC['titulo']]) . ' - ' . ($Web['config']['nombre_web'] ?? '') ?>">
								</div>
								<p><?= $AC['titulo'] ?></p>
							</a>
						</div>
					<?php endif; ?>
<?php unset($ACR);
					unset($AC);
				}
			}
			echo '</section>';
		}
	}
} ?>