<?php $Apartado='anuncios'; ?>
<section class="panel">
	<style>.label-a > label { display: flex; flex-wrap:wrap; flex-direction: column; gap: 4px; }</style>
	<form method="post" class="label-a" action="procesa/procesa.panel.php">
		<b><?= Language(['anuncios', 'title'], 'dashboard') ?></b><hr>
		<b><?= Language('links') ?>:</b><hr>
		<?php
		echo pInput(['type'=>'url','name'=>'enlace_anuncio_mensaje_movimiento','value'=>(isset($Web[$Apartado]['enlace_anuncio_mensaje_movimiento']) ? $Web[$Apartado]['enlace_anuncio_mensaje_movimiento'] : ''),'placeholder'=>'https://'.(strtolower(Language('link'))).'.com','texto'=>Language(['anuncios', 'moving-message'], 'dashboard'),'label'=>true]).
		pInput(['type'=>'url','name'=>'enlace_anuncio_mini_banner','value'=>(isset($Web[$Apartado]['enlace_anuncio_mini_banner']) ? $Web[$Apartado]['enlace_anuncio_mini_banner'] : ''),'placeholder'=>'https://'.(strtolower(Language('link'))).'.com','texto'=>Language(['anuncios', 'long-image'], 'dashboard'),'label'=>true]).
		pInput(['type'=>'url','name'=>'enlace_anuncio_miniatura_article','value'=>(isset($Web[$Apartado]['enlace_anuncio_miniatura_article']) ? $Web[$Apartado]['enlace_anuncio_miniatura_article'] : ''),'placeholder'=>'https://'.(strtolower(Language('link'))).'.com','texto'=>Language(['anuncios', 'article-thumbnail'], 'dashboard'),'label'=>true]).'<hr><div>'.
		pEnlace(['texto'=>Language('upload-image'),'icono'=>'fas fa-external-link-alt','class'=>'boton-2 boton-mini','target'=>'_blank','href'=>'?ap=subir_imagen']).'</div><hr>'.
		pSelectArchivos(['name'=>'imagen_anuncio_mini_banner','label'=>true,'texto'=>Language(['anuncios', 'long-image'], 'dashboard'),'ruta'=>$Web['directorio'].'assets/img/','tipo_archivos'=>'png,jpg,jpeg,gif','value'=>(isset($Web[$Apartado]['imagen_anuncio_mini_banner']) ? $Web[$Apartado]['imagen_anuncio_mini_banner'] : '')]).
		pSelectArchivos(['name'=>'imagen_anuncio_miniatura_article','label'=>true,'texto'=>Language(['anuncios', 'article-thumbnail'], 'dashboard'),'ruta'=>$Web['directorio'].'assets/img/','tipo_archivos'=>'png,jpg,jpeg,gif','value'=>(isset($Web[$Apartado]['imagen_anuncio_miniatura_article']) ? $Web[$Apartado]['imagen_anuncio_miniatura_article'] : '')]).'<hr>'.
		pTextarea(['placeholder'=>Language(['anuncios', 'placeholder-textarea'], 'dashboard'),'required'=>true,'name'=>'anuncio_mensaje_movimiento_texto','value'=>(isset($Web[$Apartado]['anuncio_mensaje_movimiento_texto']) ? $Web[$Apartado]['anuncio_mensaje_movimiento_texto'] : ''),'style'=>'min-height:150px;','label'=>true,'texto'=>Language(['anuncios', 'moving-message'], 'dashboard')]).
		'<hr><b>'.(Language('show')).'</b><div>'.
		pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_anuncio_mensaje_movimiento','texto2'=>Language(['anuncios', 'moving-message'], 'dashboard'),'title'=>Language(['anuncios', 'moving-message-title'], 'dashboard')]).' '.
		pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_anuncio_mini_banner','texto2'=>Language(['anuncios', 'long-image'], 'dashboard'),'title'=>Language(['anuncios', 'long-image-title'], 'dashboard')]).' '.
		pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_anuncio_miniatura_article','texto2'=>Language(['anuncios', 'article-thumbnail'], 'dashboard'),'title'=>Language(['anuncios', 'article-thumbnail-title'], 'dashboard')]).'<hr>'.
		pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>(Language('update'))]).
		'</div>'.'<hr>';
		?>
		<?= SCRIPTS->xv($Apartado) ?>
	</form>
</section>