<?php if(isset($Web['anuncios']['mostrar_anuncio_miniatura_article']) && !empty($Web['anuncios']['mostrar_anuncio_miniatura_article'])) { global $Web; ?>
	<a class="anuncio-article-miniatura" target="_blank" href="<?= $Web['anuncios']['enlace_anuncio_miniatura_article'] ?? '' ?>">
		<img style="max-width: 100%;" src="<?= $Web['config']['https_imagen']; ?><?= $Web['anuncios']['imagen_anuncio_miniatura_article'] ?? '' ?>">
	</a>
<?php } ?>