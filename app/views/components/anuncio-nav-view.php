<?php if($Web['ruta_completa'] != '../admin/admin.php'): global $AX;
if(isset($AX['anuncio']) && !empty($AX['anuncio'])) {
	echo '<center>';
	if (isset($Web['ads']['mostrar_anuncio_mensaje_movimiento']) && !empty($Web['ads']['mostrar_anuncio_mensaje_movimiento'])){ ?>
		<div class="anuncio-marquee">
			<a target="_blank" href="<?= $Web['ads']['enlace_anuncio_mensaje_movimiento'] ?? '' ?>">
				<marquee direction="left" onmouseout="start();" onmouseover="stop();" scrollamount="10" scrolldelay="145">
					<?= isset($Web['ads']['anuncio_mensaje_movimiento_texto']) ? SCRIPTS->Commands($Web['ads']['anuncio_mensaje_movimiento_texto']) : '' ?>
				</marquee>
			</a>
		</div>
	<?php }
	if (isset($Web['ads']['mostrar_anuncio_mini_banner']) && !empty($Web['ads']['mostrar_anuncio_mini_banner'])) { ?>
		<div class="anuncio-mini-banner">
			<a target="_blank" href="<?= $Web['ads']['enlace_anuncio_mini_banner'] ?? '' ?>">
				<img loading="lazy" src="<?= $Web['config']['https_imagen']; ?><?= $Web['ads']['imagen_anuncio_mini_banner'] ?? '' ?>">
			</a>
		</div>
		<hr>
	<?php }
	echo '</center>';
}
endif; ?>