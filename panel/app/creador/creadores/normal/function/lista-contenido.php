<?php function listaContenido(string $archivo_publicaciones = 'app/database/publicaciones/publicaciones.php', string $tipo = 'entrada-normal', string $opcion = '', array $lista, array $titulo, string $ruta)
{
	global $Web;
	#$archivo_publicaciones = $Web['directorio'].AppDatabase('publicaciones/publicaciones');
	$archivo_publicaciones = substr($archivo_publicaciones, 0, 4) != 'http' ? $Web['directorio'] . $archivo_publicaciones : $archivo_publicaciones;
	if (file_exists($archivo_publicaciones)) {
		$lista_publicaciones = require_once $archivo_publicaciones;
		if (!empty($lista_publicaciones)) {
			$titulos = empty($ruta) ? $titulo['titulo'] : $titulo['titulo-alternativo'];
			echo '<hr>';
			if (!empty($titulos)) {
				echo '<section class="con t-center">' . $titulos . '</section><hr>';
			}
			echo $tipo == 'entrada-normal' ? '<section class="index-entrada">' : '<section class="normal-directorio">';
			foreach (array_reverse($lista_publicaciones) as $archivo) {
				$archivo_db = "{$Web['directorio']}app/database/publicaciones/pu_$archivo";
				if (file_exists($archivo_db)) {
					require $archivo_db; ?>
					<?php if ($tipo == 'entrada-normal'): ?>
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
											require $Web['directorio'] . 'app/database/publicaciones/' . $AC['referencia'];
										} ?>
										<?= $AC['titulo'] ?? ''; ?></p>
								</div>
							</div>
						</a>
					<?php endif; ?>
					<?php if ($tipo == 'entrada-poster'): ?>
						<div class="elemento">
							<a href="<?= $Web['directorio'] . $AC['ruta'] . SCRIPTS->quitarEPHP($AC['archivo']) . $Web['config']['php'] ?>">
								<div class="imagen">
									<img loading="lazy" src="<?= ImagenesACX($AC, $Web['directorio'] . AssetsImg('logo.png')) ?>" alt="Poster de <?= $AC['titulo'] . ' en ' . ($Web['config']['nombre_web'] ?? '') ?>">
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