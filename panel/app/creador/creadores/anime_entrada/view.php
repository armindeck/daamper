<?php if (!isset($_GET['view']) || isset($_GET['view']) && in_array($_GET['view'], ['main'])): ?>
<?php if (
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
			<a href="<?= $Web['directorio']; ?>"><i class="fas fa-inicio"></i> Inicio</a> > <?php
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
				<img class="poster" loading="lazy" src="<?= ImagenesACX($AX, false, ['poster', 'poster_url']) ?>" title="Poster de <?= $AX['titulo_normal'].' - '.$Web['config']['nombre_web']; ?>" alt="Poster de <?= $AX['titulo_normal'].' - '.$Web['config']['nombre_web']; ?>">
				<div class="opciones">
					<div style="text-align: center;">
						<a class="boton2 t-12" href="#?ac=me_gusta"><i class="fas fa-thumbs-up"></i> <?= (LANGUAJE['global']['like'][CONFIG['languaje']]) ?></a>
						<a class="boton2 t-12" href="#?ac=seguir"><i class="fas fa-heart"></i> <?= (LANGUAJE['global']['follow'][CONFIG['languaje']]) ?></a>
					</div>
					<a class="boton boton-estado" style="color: <?= $AX['estado'] == 'Suspendido' ? '#000' : '#FFF'; ?>; background: <?= $AX['estado'] == 'Emisión' ? 'green' : ($AX['estado'] == 'Finalizado' ? 'red' : 'yellow'); ?>;" href="#?tags=<?= SCRIPTS->archivoAceptado($AX['estado']); ?>"><i class="fas fa-tv"></i> <?= $AX['estado'] ?></a>
				</div>
			</aside>
			<div class="con der-content">
				<h3><?= (LANGUAJE['global']['synopsis'][CONFIG['languaje']]) ?></h3><hr>
				<p class="t-14 sinopsis scrolls" style="margin: 8px 0px;"><?= $AX['sinopsis']; ?></p><hr>
				<details open>
					<summary><small><?= (LANGUAJE['global']['details'][CONFIG['languaje']]) ?></small></summary>
					<ul class="t-14">
						<li><?= (LANGUAJE['global']['language'][CONFIG['languaje']]) ?>: <?= $AX['idioma']; ?></li>
						<li><?= (LANGUAJE['global']['subtitle'][CONFIG['languaje']]) ?>: <?= $AX['subtitulo']; ?></li>
						<li><?= (LANGUAJE['global']['episodes'][CONFIG['languaje']]) ?>: <?= $AX['estado'] == 'Finalizado' ? $AX['episodios'] : '¿?'; ?></li>
						<li><?= (LANGUAJE['global']['premiere'][CONFIG['languaje']]) ?>: <?= SCRIPTS->fechasInputDate($AX['estreno']); ?></li>
						<?= $AX['estado'] == 'Finalizado' && isset($AX['finalizo']) ? "<li>".(LANGUAJE['global']['ended'][CONFIG['languaje']]).":  ". (SCRIPTS->fechasInputDate($AX['finalizo'])) ."</li>" : '' ?>
					</ul>
				</details>
				<hr>
				<p class="t-14" style="margin-bottom: 8px;"><b><?= (LANGUAJE['global']['genres'][CONFIG['languaje']]) ?></b></p>
				<?php require __DIR__ . '/scripts.php';
				foreach ($lista_categorias as $key => $value) {
					if(isset($AX[SCRIPTS->archivoAceptado($value)]) &&
						!empty($AX[SCRIPTS->archivoAceptado($value)])
					){
						echo '<a class="boton-2 t-14 boton-mini" href="#?tags='.SCRIPTS->archivoAceptado($value).'">'.$value.'</a>';
					}
				} ?>
			</div>
		</div><br>
		<?php if ($AX['estado'] == 'Emisión' && $AX['ruta'] == 'anime/'): ?>
		<div class="con" style="text-align: center; background: green; color: white; font-weight: bold; text-transform: uppercase;">
			<i class="fas fa-calendar"></i> <?= (LANGUAJE['global']['episodes-every-thursday'][CONFIG['languaje']][0]) . ($AX['episodios_cada'] ?? '') . (LANGUAJE['global']['episodes-every-thursday'][CONFIG['languaje']][1]) ?>
		</div>
		<?php endif; ?>
		<form method="get" class="formulario t-14 flex-between">
			<p style="font-size: 16px; font-weight: bold; text-transform: uppercase;"><i class="fas fa-list-ol"></i> <?= (LANGUAJE['global']['episode-list'][CONFIG['languaje']]) ?></p>
			<section>
				<?= pSelect(['name'=>'ordenar_episodios','texto'=>(LANGUAJE['global']['sort-by'][CONFIG['languaje']]),'option'=>['asc' => (LANGUAJE['global']['ascending'][CONFIG['languaje']]),'desc' => (LANGUAJE['global']['descending'][CONFIG['languaje']])],'des_session'=>true,'value'=>(isset($_GET['ordenar_episodios']) ? SCRIPTS->normalizar2($_GET['ordenar_episodios']) : '')]).' '.
				pInput(['type'=>'number','min'=>0,'max'=>$AX['episodios'],'name'=>'cantidad_episodios','class'=>'form-campo-pequeno','value'=>(isset($_GET['cantidad_episodios']) && is_numeric($_GET['cantidad_episodios']) && $_GET['cantidad_episodios'] <= $AX['episodios'] ? SCRIPTS->normalizar2($_GET['cantidad_episodios']) : $AX['episodios']),'label'=>true,'des_session'=>true,'texto'=>(LANGUAJE['global']['quantity'][CONFIG['languaje']])]).' '.
				pInput(['type'=>'submit','class'=>'boton','value'=>(LANGUAJE['global']['sort'][CONFIG['languaje']]),'des_session'=>true]);
				?>
			</section>
		</form>
		<div class="div-episodios scrolls campo">
		<?php
			$anime_entrada['ruta_archivos_buscar']=$Web['directorio'].'ver/'.SCRIPTS->sinEPHP($AX['archivo']);
			$anime_entrada['episodios_buscar']=glob($anime_entrada['ruta_archivos_buscar'].'*.{php}', GLOB_BRACE);
			
			sort($anime_entrada['episodios_buscar'], SORT_NATURAL | SORT_FLAG_CASE);
			$anime_entrada['get_ordenar_episodios']='asc';
			if(!isset($_GET['ordenar_episodios']) or empty($_GET['ordenar_episodios']) or $_GET['ordenar_episodios']=='desc'){
				$anime_entrada['episodios_buscar']=array_reverse($anime_entrada['episodios_buscar']);
				$anime_entrada['get_ordenar_episodios']='desc';
			}

			$anime_entrada['get_cantidad_episodios']=$AX['episodios'];
			if(isset($_GET['cantidad_episodios']) && is_numeric($_GET['cantidad_episodios']) && $_GET['cantidad_episodios'] <= $AX['episodios']){
				$anime_entrada['get_cantidad_episodios'] = SCRIPTS->normalizar2($_GET['cantidad_episodios']);
			}
			
			$i_sigue=0;
			foreach ($anime_entrada['episodios_buscar'] as $key => $value) {

				if($anime_entrada['get_ordenar_episodios']=='asc'){
					if($i_sigue<$anime_entrada['get_cantidad_episodios']){ $anime_entrada['sigue']=true; }
				} else {
					if($i_sigue<$anime_entrada['get_cantidad_episodios']){ $anime_entrada['sigue']=true; }
				}

				if(isset($anime_entrada['sigue'])){
					$value=SCRIPTS->sinEPHP($value);
					$anime_entrada['valor_a']=str_replace($anime_entrada['ruta_archivos_buscar'], '', $value);
					$anime_entrada['valor_a'] = substr($anime_entrada['valor_a'], 1, strlen($anime_entrada['valor_a']));

					echo '<a class="boton t-16" href="'.$value.$Web['config']['php'].'"><i class="fas fa-play-circle"></i> '.$AX['titulo_normal'].' <strong>'.(LANGUAJE['global']['episode'][CONFIG['languaje']]).' '.$anime_entrada['valor_a'].'</strong></a>';
					unset($anime_entrada['sigue']);
				}

				$i_sigue++;

			}
		?>
		</div>
		<?php FormComentario() ?>
	</div>
</div>
<?php endif; ?>
<?= isset($_GET['view']) && in_array($_GET['view'], ['comentarios']) ? FormComentario() : '' ?>