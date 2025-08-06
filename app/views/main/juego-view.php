<?php if (!isset($_GET['view']) || isset($_GET['view']) && in_array($_GET['view'], ['main'])): ?>
<?php global $AXR, $AX; if (
	isset($AX['banner']) && !empty($AX['banner']) && file_exists($Web['directorio'].$AX['banner']) ||
	isset($AX['banner_url']) && !empty($AX['banner_url'])
): $isset_banner = true; ?>
<style type="text/css">
	.anime_entrada-banner {
		background: url('<?= ImagenesACX($AX, false, ['banner', 'banner_url']) ?>');
		background-position: center center, center top;
		background-repeat: repeat, no-repeat;
		background-size: cover;
		background-position-y: center;
	}
</style>
<div class="anime_entrada-banner">
	<div class="contenido">
		<h2><?= $AX['titulo_normal']; ?></h2>
	</div>
</div>
<?php endif; ?>
<div class="anime_entrada">
	<div class="izq">
		<div class="url">
			<a href="<?= $Web['directorio']; ?>"><i class="fas fa-inicio"></i> <?= Language('home') ?></a> > <?php
				$anime_entrada['explode_ruta'] = explode('/', $AX['ruta']);
				$anime_entrada['coun_ruta']=count($anime_entrada['explode_ruta'])-1;
				foreach ($anime_entrada['explode_ruta'] as $key => $value) {
					echo '<a href="'.$Web['directorio'].$value.'/">'.$value.'</a>';
					if($key < $anime_entrada['coun_ruta']){ echo ' > '; }
				}
				echo $AX['titulo_normal'];
			?>
		</div>
		<?php if(!isset($isset_banner)): ?>
		<h2 style="margin-bottom: 6px;"><?= $AX['titulo_normal']; ?></h2>
		<?php endif; unset($isset_banner); ?>
		<div class="media-lista">
			<aside class="izq-content">
				<img class="poster" loading="lazy" src="<?= ImagenesACX($AX, false, ['poster', 'poster_url']) ?>" title="<?= Language('poster-of', 'global', ['value' => $AX['titulo_normal']]).' - '.$Web['config']['nombre_web']; ?>" alt="<?= Language('poster-of', 'global', ['value' => $AX['titulo_normal']]).' - '.$Web['config']['nombre_web']; ?>">
				<div class="opciones">
					<div style="text-align: center;">
						<a class="boton2 t-12" href="#"><i class="fas fa-thumbs-up"></i> <?= Language('like') ?></a>
						<a class="boton2 t-12" href="#"><i class="fas fa-heart"></i> <?= Language('follow') ?></a>
					</div>
					<a class="boton boton-estado" style="color: <?= $AX['estado'] == 'suspended' ? '#000' : '#FFF'; ?>; background: <?= $AX['estado'] == 'development' ? 'green' : ($AX['estado'] == 'completed' ? 'red' : 'yellow'); ?>;" href="#"><i class="fas fa-tv"></i> <?= Language($AX['estado']) ?></a>
				</div>
			</aside>
			<div class="con der-content">
				<h3><?= Language('information') ?></h3><hr>
				<p class="t-14 sinopsis scrolls" style="margin: 8px 0px;"><?= Daamper::$scripts->Commands($AX['sinopsis']); ?></p><hr>
				<details class="t-14" open>
					<summary><?= Language('details') ?></summary>
					<ul class="t-14">
						<?php foreach ([
							Language('title') => ['name' => 'titulo_normal'],
							Language('development') => ['name' => 'Desarrollador'],
							Language('languages') => ["name" => "Idiomas"],
							Language('subtitles') => ["name" => "Subtitulos"],
							Language('state') => ["name" => "Estado"],
							Language('version') => ["name" => "Versión"],
							Language('released') => ["name" => "Lanzado"],
							Language('completed') => ["name" => "Terminado"]
							] as $key => $item) {
							if (!is_string($key)) {
								$key_name = Daamper::$scripts->archivoAceptado($item);
							} else {
								$key_name = Daamper::$scripts->archivoAceptado((isset($item['name']) ? $item['name'] : $key));
							}
							if (isset($AX[$key_name]) && !empty($AX[$key_name])) {
								echo "<li>";
								echo is_string($key) ? $key : $item;
								echo ": ";
								echo $key_name == "estado" ? (Language($AX[$key_name]) ?? $AX[$key_name]) : $AX[$key_name];
								if ($key_name == 'version' && isset($AX['version_estado']) && !empty($AX['version_estado'])) {
									echo " " . $AX['version_estado'];
								}
								echo "</li>";
							}
						} ?>
					</ul>
				</details>
				<?php require RAIZ . "app/actions/admin/content/global/creators/script/juego.php"; ?>
				<?php foreach ($lista_os_requisitos as $os) {
					$os_name = Daamper::$scripts->archivoAceptado($os);
					if (isset($AX['os_'.$os_name]) && !empty($AX['os_'.$os_name])){
						$mostrar_requisitos = true; break;
					}
				} if (isset($mostrar_requisitos)): ?>
				<?php foreach (['minimo', "recomendado"] as $value): ?>
					<details class="t-14">
						<summary><?= Language($value == 'minimo' ? 'minimum-requirements' : 'recommended-requirements') ?></summary>
						<section>
							<section style="margin-bottom: 4px;">
								<?php foreach ($lista_os_requisitos as $os){ $os_name = Daamper::$scripts->archivoAceptado($os);
								if (isset($AX['os_'.$os_name]) && !empty($AX['os_'.$os_name])){ ?>
								<details><summary><?= $os ?></summary><section><ul>
									<?php foreach (['versión', 'procesador', 'targeta_grafica', 'ram', 'ram_mb_or_gb', 'espacio', 'espacio_mb_or_gb'] as $valor){ $valor_name = Daamper::$scripts->archivoAceptado($valor);
									 if(isset($AX["requisito_{$value}_os_{$os_name}_{$valor_name}"]) && !empty(($AX["requisito_{$value}_os_{$os_name}_{$valor_name}"]))) {
									 	if(!in_array($valor_name, ['ram_mb_or_gb', 'peso_mb_or_gb', 'espacio_mb_or_gb'])) {
										 	echo "<li>".(Language($valor == 'versión' ? 'version' : ($valor == 'procesador' ? 'processor' : ($valor == 'targeta_grafica' ? 'graphics-card' : ($valor == 'espacio' ? 'storage' : 'ram'))))).": ". $AX["requisito_{$value}_os_{$os_name}_{$valor_name}"];
										 	if (in_array($valor_name, ['ram', 'espacio'])) {
										 		echo $AX["requisito_{$value}_os_{$os_name}_{$valor_name}_mb_or_gb"] ?? '';
										 	}
										 	echo "</li>";
									 	}
									 }
									} ?>
								</ul></section></details>
								<?php } }; ?>
							</section>
						</section>
					</details>
				<?php endforeach; ?>
				<?php endif; ?>
				<?php if (isset($AX['otros_nombres']) && !empty($AX['otros_nombres'])): ?>
				<details class="t-14"><summary><?= Language('other-names') ?></summary>
					<section><?= $AX['otros_nombres'] ?></section>
				</details>
				<?php endif; ?>
				<hr>
				<details open>
					<summary class="t-14"><?= Language('genres') ?></summary>
					<section>
						<?php foreach ($lista_generos as $key => $value) {
							if(isset($AX["genre_".Daamper::$scripts->archivoAceptado($value)]) &&
								!empty($AX["genre_".Daamper::$scripts->archivoAceptado($value)])
							){
								echo '<a class="boton-2 t-14 boton-mini" href="#">'.(Language(["games-tags", $value], "global") ?? $value).'</a>';
							}
						} ?>
					</section>
				</details>
				<details>
					<summary class="t-14"><?= Language('operating-systems') ?></summary>
					<section>
						<?php foreach ($lista_os as $key => $value) {
							if(isset($AX["os_".Daamper::$scripts->archivoAceptado($value)]) &&
								!empty($AX["os_".Daamper::$scripts->archivoAceptado($value)])
							){
								echo '<a class="boton-2 t-14 boton-mini" href="#">'.($value).'</a>';
							}
						} ?>
					</section>
				</details>
				</details>
				<details>
					<summary class="t-14"><?= Language('engines') ?></summary>
					<section>
						<?php foreach ($lista_motores as $key => $value) {
							if(isset($AX["engine_".Daamper::$scripts->archivoAceptado($value)]) &&
								!empty($AX["engine_".Daamper::$scripts->archivoAceptado($value)])
							){
								echo '<a class="boton-2 t-14 boton-mini" href="#">'.(Language(["game-engine", $value], "global") ?? $value).'</a>';
							}
						} ?>
					</section>
			</div>
		</div>
		<section class="con">
			<details open><summary><?= Language('gallery') ?></summary>
				<section class="gallery">
					<?php for ($i = 1; $i <= $AX['galeria_cantidad'] ?? 1; $i++) { ?>
					<div class="imagen">
						<img loading="lazy" src="<?= ImagenesACX($AX, false, ["galeria_{$i}", "galeria_{$i}_url"]) ?>" title="<?= Language('image-of', 'global', ['value' => $AX['titulo_normal']]).' - '.$Web['config']['nombre_web']; ?>">
					</div>
					<?php } ?>
				</section>
			</details>
		</section>
		<?php if (isset($AX['informacion_extra']) && !empty($AX['informacion_extra'])): ?>
		<section class="con">
			<details open><summary><?= Language('extra-information') ?></summary>
				<section><?= $AX['informacion_extra'] ?></section>
			</details>
		</section>
		<?php endif; ?>
		<section class="con">
			<details open><summary><?= Language('download-zone') ?></summary>
				<section>
					<?php foreach ($lista_os as $os){ $os_name = Daamper::$scripts->archivoAceptado($os);
						if (isset($AX['os_'.$os_name]) && !empty($AX['os_'.$os_name])){ ?>
						<details><summary><?= $os ?></summary><section>
							<?php if (isset($AX["descarga_cantidad_os_{$os_name}"]) && !empty($AX["descarga_cantidad_os_{$os_name}"])){
								for ($i = 1; $i <= $AX["descarga_cantidad_os_{$os_name}"]; $i++) {
									if (isset($AX["descarga_servidor_{$i}_{$os_name}"]) && !empty($AX["descarga_servidor_{$i}_{$os_name}"]) && isset($AX["descarga_enlace_acortado_{$i}_{$os_name}"]) && !empty($AX["descarga_enlace_acortado_{$i}_{$os_name}"])){
										echo '<section class="flex-between"><span>'. (isset($AX["descarga_version_{$i}_{$os_name}"]) && !empty($AX["descarga_version_{$i}_{$os_name}"]) ? "v".($AX["descarga_version_{$i}_{$os_name}"]) : (isset($AX['version']) && !empty($AX['version']) ? "v{$AX['version']}" : Language('download'))) . ':</span> <section>';
										echo isset($AX["descarga_peso_{$i}_{$os_name}"]) && !empty($AX["descarga_peso_{$i}_{$os_name}"]) ? '<span>'.$AX["descarga_peso_{$i}_{$os_name}"] : '';
										echo (isset($AX["descarga_peso_{$i}_{$os_name}_mb_or_gb"]) && !empty($AX["descarga_peso_{$i}_{$os_name}_mb_or_gb"]) ? $AX["descarga_peso_{$i}_{$os_name}_mb_or_gb"] : '') . '</span> ';
										echo '<a target="_blank" class="boton" href="'. $AX["descarga_enlace_acortado_{$i}_{$os_name}"] .'">'.($AX["descarga_servidor_{$i}_{$os_name}"]).' <i class="fas fa-download"></i></a>';
										if(isset($AX["descarga_enlace_directo_{$i}_{$os_name}"]) && !empty($AX["descarga_enlace_directo_{$i}_{$os_name}"])) {
											if (isset($_SESSION['id']) && $_SESSION['id'] != 'Usuario') {
												echo ' <a target="_blank" class="boton-2" href="'. $AX["descarga_enlace_directo_{$i}_{$os_name}"] .'">'.Language('direct').' <i class="fas fa-bolt"></i></a>';
											}
										}
										echo '</section></section>';
									}
								}
							} ?>
						</section></details>
					<?php } } ?>
				</section>
			</details>
		</section>
		<?php FormComentario() ?>
	</div>
</div>
<?php endif; ?>
<?= isset($_GET['view']) && in_array($_GET['view'], ['comentarios']) ? FormComentario() : '' ?>