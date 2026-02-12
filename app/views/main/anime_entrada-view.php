<?php

/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  juego-view.php                                                        */
/**************************************************************************/
/*                        This file is part of:                           */
/*                              daamper                                   */
/*                 https://github.com/armindeck/daamper                   */
/**************************************************************************/
/* Copyright (c) 2025 DBHS / daamper                                      */
/*                                                                        */
/* Se concede permiso, de forma gratuita, a cualquier persona para usar,  */
/* modificar y ejecutar el código fuente de este software, incluyendo su  */
/* uso en proyectos comerciales (como monetización por publicidad o       */
/* donaciones).                                                           */
/*                                                                        */
/* Restricciones estrictas:                                               */
/* - No está permitido vender, sublicenciar o distribuir el código        */
/*   fuente —total o parcialmente— con fines de lucro.                    */
/* - No está permitido convertir el código en privativo ni eliminar       */
/*   esta licencia.                                                       */
/* - No está permitido reclamar la autoría del código original.           */
/*                                                                        */
/* Uso permitido:                                                         */
/* - Se permite modificar y usar el código con fines personales,          */
/*   educativos y/o comerciales, siempre que no se venda.                 */
/* - Se permite usar este software como base para otros proyectos,        */
/*   siempre que esta licencia se mantenga.                               */
/*                                                                        */
/* El autor (DBHS / daamper) se reserva el derecho de modificar esta      */
/* licencia en futuras versiones del software.                            */
/*                                                                        */
/* EL SOFTWARE SE ENTREGA "TAL CUAL", SIN GARANTÍAS DE NINGÚN TIPO,       */
/* EXPRESAS O IMPLÍCITAS, INCLUYENDO, SIN LIMITACIÓN, GARANTÍAS DE        */
/* COMERCIABILIDAD, IDONEIDAD PARA UN PROPÓSITO PARTICULAR Y NO           */
/* INFRACCIÓN. EN NINGÚN CASO LOS AUTORES SERÁN RESPONSABLES POR          */
/* RECLAMACIONES, DAÑOS U OTRAS RESPONSABILIDADES, YA SEA EN UNA ACCIÓN   */
/* CONTRACTUAL, EXTRACONTRACTUAL O DE OTRO TIPO, DERIVADAS DE O EN        */
/* CONEXIÓN CON EL SOFTWARE, SU USO O OTRO TIPO DE MANEJO.                */
/**************************************************************************/

if (!isset($_GET['view']) || isset($_GET['view']) && in_array($_GET['view'], ['main'])): ?>
<?php
// Import Markdown libraries
require_once RAIZ . 'app/scripts/lib/Markdown.php';
require_once RAIZ . 'app/scripts/lib/MarkdownExtra.php';
?>
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
					<a class="boton boton-estado" style="color: <?= $AX['estado'] == 'suspended' ? '#000' : '#FFF'; ?>; background: <?= $AX['estado'] == 'airing' ? 'green' : ($AX['estado'] == 'finalized' ? 'red' : 'yellow'); ?>;" href="#"><i class="fas fa-tv"></i> <?= Language($AX['estado']) ?></a>
				</div>
			</aside>
			<div class="con der-content">
				<h3><?= Language('synopsis') ?></h3><hr>
				<p class="t-14 sinopsis scrolls" style="margin: 8px 0px;"><?= Michelf\MarkdownExtra::defaultTransform($AX["sinopsis"] ?? "") ?></p><hr>
				<details open>
					<summary><small><?= Language('details') ?></small></summary>
					<ul class="t-14">
						<li><?= Language('language') ?>: <?= Language($AX['idioma']) ?? $AX['idioma'] ?></li>
						<li><?= Language('subtitle') ?>: <?= Language($AX['subtitulo']) ?? $AX['subtitulo'] ?></li>
						<li><?= Language('episodes') ?>: <?= $AX['estado'] == 'finalized' ? $AX['episodios'] : '¿?'; ?></li>
						<li><?= Language('premiere') ?>: <?= $AX['estreno'] ?></li>
						<?= $AX['estado'] == 'finalized' && isset($AX['finalizo']) ? "<li>".(Language('ended')).":  ". $AX['finalizo'] ."</li>" : '' ?>
					</ul>
				</details>
				<hr>
				<p class="t-14" style="margin-bottom: 8px;"><b><?= Language('genres') ?></b></p>
				<?php require RAIZ . "app/actions/admin/content/global/creators/script/anime_entrada.php";
				foreach ($lista_categorias as $key => $value) {
					if(isset($AX[Daamper::$scripts->archivoAceptado($key)]) &&
						!empty($AX[Daamper::$scripts->archivoAceptado($key)])
					){
						echo '<a class="boton-2 t-14 boton-mini" href="#">'.$value.'</a>';
					}
				} ?>
			</div>
		</div><br>
		<?php if ($AX['estado'] == 'airing' && $AX['ruta'] == 'anime/'): ?>
		<div class="con" style="text-align: center; background: green; color: white; font-weight: bold; text-transform: uppercase;">
			<i class="fas fa-calendar"></i> <?= (Language('episodes-every-thursday', 'global', ['value' => $AX['episodios_cada'] ?? ''])) ?>
		</div>
		<?php endif; ?>
		<form method="get" class="formulario t-14 flex-between" style="margin: 4px 6px 0px 6px;">
			<p style="font-size: 16px; font-weight: bold; text-transform: uppercase;"><i class="fas fa-list-ol"></i> <?= Language('episode-list') ?></p>
			<section>
				<?= pSelect(['name'=>'ordenar_episodios','texto'=>Language('sort-by'),'option'=>['asc' => Language('ascending'),'desc' => Language('descending')],'des_session'=>true,'value'=>(isset($_GET['ordenar_episodios']) ? Daamper::$scripts->normalizar2($_GET['ordenar_episodios']) : '')]).' '.
				pInput(['type'=>'number','min'=>0,'max'=>$AX['episodios'],'name'=>'cantidad_episodios','class'=>'form-campo-pequeno','value'=>(isset($_GET['cantidad_episodios']) && is_numeric($_GET['cantidad_episodios']) && $_GET['cantidad_episodios'] <= $AX['episodios'] ? Daamper::$scripts->normalizar2($_GET['cantidad_episodios']) : $AX['episodios']),'label'=>true,'des_session'=>true,'texto'=>Language('quantity')]).' '.
				pInput(['type'=>'submit','class'=>'boton','value'=>Language('sort'),'des_session'=>true]);
				?>
			</section>
		</form>
		<div class="div-episodios scrolls campo">
		<?php
			$anime_entrada['ruta_archivos_buscar']=$Web['directorio'].'ver/'.Daamper::$scripts->sinEPHP($AX['archivo']);
			$anime_entrada['episodios_buscar']=glob($anime_entrada['ruta_archivos_buscar'].'*.{php}', GLOB_BRACE);
			
			sort($anime_entrada['episodios_buscar'], SORT_NATURAL | SORT_FLAG_CASE);
			$anime_entrada['get_ordenar_episodios']='asc';
			if(!isset($_GET['ordenar_episodios']) or empty($_GET['ordenar_episodios']) or $_GET['ordenar_episodios']=='desc'){
				$anime_entrada['episodios_buscar']=array_reverse($anime_entrada['episodios_buscar']);
				$anime_entrada['get_ordenar_episodios']='desc';
			}

			$anime_entrada['get_cantidad_episodios']=$AX['episodios'];
			if(isset($_GET['cantidad_episodios']) && is_numeric($_GET['cantidad_episodios']) && $_GET['cantidad_episodios'] <= $AX['episodios']){
				$anime_entrada['get_cantidad_episodios'] = Daamper::$scripts->normalizar2($_GET['cantidad_episodios']);
			}
			
			$i_sigue=0;
			foreach ($anime_entrada['episodios_buscar'] as $key => $value) {

				if($anime_entrada['get_ordenar_episodios']=='asc'){
					if($i_sigue<$anime_entrada['get_cantidad_episodios']){ $anime_entrada['sigue']=true; }
				} else {
					if($i_sigue<$anime_entrada['get_cantidad_episodios']){ $anime_entrada['sigue']=true; }
				}

				if(isset($anime_entrada['sigue'])){
					$value=Daamper::$scripts->sinEPHP($value);
					$anime_entrada['valor_a']=str_replace($anime_entrada['ruta_archivos_buscar'], '', $value);
					$anime_entrada['valor_a'] = substr($anime_entrada['valor_a'], 1, strlen($anime_entrada['valor_a']));

					echo '<a class="boton t-16" href="'.$value.$Web['config']['php'].'"><i class="fas fa-play-circle"></i> '.$AX['titulo_normal'].' <strong>'.(Language('episode')).' '.$anime_entrada['valor_a'].'</strong></a>';
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