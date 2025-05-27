<?php if(isset($Web['ads']['mostrar_anuncio_miniatura_article']) && !empty($Web['ads']['mostrar_anuncio_miniatura_article'])) { global $Web; ?>
	<a class="anuncio-article-miniatura" target="_blank" href="<?= $Web['ads']['enlace_anuncio_miniatura_article'] ?? '' ?>">
		<img style="max-width: 100%;" src="<?= $Web['config']['https_imagen']; ?><?= $Web['ads']['imagen_anuncio_miniatura_article'] ?? '' ?>">
	</a>
<?php } ?>