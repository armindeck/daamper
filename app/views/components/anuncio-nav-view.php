<?php if($Web['ruta_completa'] != '../panel/panel.php'): global $AX;
if(isset($AX['anuncio']) && !empty($AX['anuncio'])) {
	echo '<center>';
	if (isset($Web['anuncios']['mostrar_anuncio_mensaje_movimiento']) && !empty($Web['anuncios']['mostrar_anuncio_mensaje_movimiento'])){ ?>
		<div class="anuncio-marquee">
			<a target="_blank" href="<?= $Web['anuncios']['enlace_anuncio_mensaje_movimiento'] ?? '' ?>">
				<marquee direction="left" onmouseout="start();" onmouseover="stop();" scrollamount="10" scrolldelay="145">
					<?= $Web['anuncios']['anuncio_mensaje_movimiento_texto'] ?? '' ?>
				</marquee>
			</a>
		</div>
	<?php }
	if (isset($Web['anuncios']['mostrar_anuncio_mini_banner']) && !empty($Web['anuncios']['mostrar_anuncio_mini_banner'])) { ?>
		<div class="anuncio-mini-banner">
			<a target="_blank" href="<?= $Web['anuncios']['enlace_anuncio_mini_banner'] ?? '' ?>">
				<img loading="lazy" src="<?= $Web['config']['https_imagen']; ?><?= $Web['anuncios']['imagen_anuncio_mini_banner'] ?? '' ?>">
			</a>
		</div>
		<hr>
	<?php }
	echo '</center>';
}
endif; ?>