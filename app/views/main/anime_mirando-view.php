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
<?php global $AXR, $AX; ?>
<section class="flex-evenly lista-ver" style="margin: 4px;">
	<section class="flex-column">
		<header style="margin-bottom: 8px;">
			<small class="ruta">
				<a href="<?= $Web['directorio']; ?>"><i class="fas fa-inicio"></i> <?= Language('home') ?></a> >
				<a href="<?= $Web['directorio'].$AX['ruta_referencia'] ?>"><?= str_replace('/', '', ucfirst($AX['ruta_referencia'])) ?></a> >
				<a href="<?= $Web['directorio'].$AX['ruta_referencia'].Daamper::$scripts->quitarEPHP($AX['archivo_referencia']).$Web['config']['php'] ?>"><?= $AX['titulo_normal'] ?></a> >
				<?= $AX['titulo'] ?>
			</small>
			<h2><?= $AX['titulo']; ?></h2>
		</header>
		<main class="flex-column">
			<header class="opciones-botones">
				<?php for ($i = 1; $i <= ($AX['cantidad_servidor_stream'] ?? 0); $i++): ?>
					<div class="opcion">
						<div class="title"><?= $AX['servidor_stream_'.$i] ?></div>
						<a href="<?= $AX['servidor_stream_'.$i.'_enlace'] ?>" rel="nofollow" target="servidor-stream"><?= Language('option') . ' '. $i ?></a>
					</div>
				<?php endfor; ?>
			</header>
			<iframe class="video" width="800" height="450" name="servidor-stream" src="<?= $AX['stream_default']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
			<section class="flex-between">
				<div class="botones">
					<?php function BotonMinMax ($Mm = false) { global $Web, $AX;
						$file = $Web['directorio'] . 'ver/';
						$file .= substr($AX['archivo'], 0, strlen($AX['archivo']) - (4 + strlen($AX['episodio'])));
						$file .= $Mm ? ($AX['episodio'] + 1) : ($AX['episodio'] - 1);
						$file .= ".php";

						if (file_exists($file)) { ?>
							<a class="boton t-14" href="<?= str_replace(".php", "", $file) . ($Web['config']['php'] ?? '') ?>">
								<?= !$Mm ? '<i class="fas fa-chevron-circle-left"></i> '.Language('previous') : Language('next').' <i class="fas fa-chevron-circle-right"></i>' ?>
							</a>
						<?php }
					} ?>
				<?= BotonMinMax() ?>
				<a class="boton t-14" href="<?= $Web['directorio'].$AX['ruta_referencia'].Daamper::$scripts->quitarEPHP($AX['archivo_referencia']).$Web['config']['php'] ?>"><i class="fas fa-bars"></i> <?= Language('list') ?></a>
				<?= BotonMinMax(true) ?>
				</div>
				<input type="checkbox" id="check-boton" hidden>
				<label class="check-boton" for="check-boton">
					<a class="boton t-14"><i class="fas fa-download"></i> <?= Language('download') ?></a>
				</label>
				<section class="con check-div" style="width: 100%;">
					<p><i class="fas fa-download"></i> <?= Language('downloads') ?></p><hr>
					<?php for ($i = 1; $i <= ($AX['cantidad_servidor_descarga'] ?? 0); $i++): ?>
						<div class="flex-between">
							<p><?= $AX['servidor_descarga_'.$i] ?></p>
							<section>
								<a class="boton t-14" href="<?= $AX['servidor_descarga_'.$i.'_enlace_acortado'] ?>" rel="nofollow" target="_blank"><i class="fas fa-arrow-alt-circle-down"></i> <?= Language('download') ?></a>
								<?php if(isset($_SESSION['rol']) && in_array(strtolower($_SESSION['rol']), ['administrador','ceo founder'])): ?>
									<a class="boton-2 t-14" href="<?= $AX['servidor_descarga_'.$i.'_enlace'] ?>" rel="nofollow" target="_blank"><i class="fas fa-bolt"></i> <?= Language('direct') ?></a>
								<?php endif; ?>
							</section>
						</div>
					<?php endfor; ?>
				</section>
			</section>
		</main>
		<footer><?php FormComentario() ?></footer>
	</section>
	<?php $default = Daamper::$data->Config("default")["entries"]["anime_mirando"]["ads"] ?? []; ?>
	<?php if(!empty($default["ads-show"])): ?>
	<article>
		<?php if(!empty($default["title-show"])): ?>
		<section class="con">
			<a href="<?= $default["link"] ?>">
				<i class="fas fa-star"></i> <?= $default["title"] ?> <i class="fas fa-star"></i>
			</a>
		</section>
		<?php endif; ?>
		<?php if(!empty($default["iframe-show"])): ?>
		<?= (new Template($Web["template"], $Web))->commands('[Return=Iframe height="890px" src="'.($default["link-iframe"]).'" get="view~main&tema~'.($_SESSION['tmp']['color'] ?? $Web["config"]["color"] ?? 'light').'"]', 0, 0) ?>
		<?php endif; ?>
	</article>
	<?php endif; ?>
</section>
<?php endif; ?>
<?= isset($_GET['view']) && in_array($_GET['view'], ['comentarios']) ? FormComentario() : '' ?>