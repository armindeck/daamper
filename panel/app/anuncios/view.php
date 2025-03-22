<?php $Apartado='anuncios'; ?>
<section class="panel">
	<style>.label-a > label { display: flex; flex-wrap:wrap; flex-direction: column; gap: 4px; }</style>
	<form method="post" class="label-a" action="procesa/procesa.panel.php">
		<b><?= LANGUAJE['dashboard']['anuncios']['title'][CONFIG['languaje']] ?></b><hr>
		<b><?= LANGUAJE['global']['links'][CONFIG['languaje']] ?>:</b><hr>
		<?php
		echo pInput(['type'=>'url','name'=>'enlace_anuncio_mensaje_movimiento','value'=>(isset($Web[$Apartado]['enlace_anuncio_mensaje_movimiento']) ? $Web[$Apartado]['enlace_anuncio_mensaje_movimiento'] : ''),'placeholder'=>'https://.com','texto'=>(LANGUAJE['dashboard']['anuncios']['moving-message'][CONFIG['languaje']]),'label'=>true]).
		pInput(['type'=>'url','name'=>'enlace_anuncio_mini_banner','value'=>(isset($Web[$Apartado]['enlace_anuncio_mini_banner']) ? $Web[$Apartado]['enlace_anuncio_mini_banner'] : ''),'placeholder'=>'https://.com','texto'=>(LANGUAJE['dashboard']['anuncios']['long-image'][CONFIG['languaje']]),'label'=>true]).
		pInput(['type'=>'url','name'=>'enlace_anuncio_miniatura_article','value'=>(isset($Web[$Apartado]['enlace_anuncio_miniatura_article']) ? $Web[$Apartado]['enlace_anuncio_miniatura_article'] : ''),'placeholder'=>'https://.com','texto'=>(LANGUAJE['dashboard']['anuncios']['article-thumbnail'][CONFIG['languaje']]),'label'=>true]).'<hr><div>'.
		pEnlace(['texto'=>(LANGUAJE['global']['upload-image'][CONFIG['languaje']]),'icono'=>'fas fa-external-link-alt','class'=>'boton-2 boton-mini','target'=>'_blank','href'=>'?ap=subir_imagen']).'</div><hr>'.
		pSelectArchivos(['name'=>'imagen_anuncio_mini_banner','label'=>true,'texto'=>(LANGUAJE['dashboard']['anuncios']['long-image'][CONFIG['languaje']]),'ruta'=>$Web['directorio'].'assets/img/','tipo_archivos'=>'png,jpg,jpeg,gif','value'=>(isset($Web[$Apartado]['imagen_anuncio_mini_banner']) ? $Web[$Apartado]['imagen_anuncio_mini_banner'] : '')]).
		pSelectArchivos(['name'=>'imagen_anuncio_miniatura_article','label'=>true,'texto'=>(LANGUAJE['dashboard']['anuncios']['article-thumbnail'][CONFIG['languaje']]),'ruta'=>$Web['directorio'].'assets/img/','tipo_archivos'=>'png,jpg,jpeg,gif','value'=>(isset($Web[$Apartado]['imagen_anuncio_miniatura_article']) ? $Web[$Apartado]['imagen_anuncio_miniatura_article'] : '')]).'<hr>'.
		pTextarea(['placeholder'=>(LANGUAJE['dashboard']['anuncios']['placeholder-textarea'][CONFIG['languaje']]),'required'=>true,'name'=>'anuncio_mensaje_movimiento_texto','value'=>(isset($Web[$Apartado]['anuncio_mensaje_movimiento_texto']) ? $Web[$Apartado]['anuncio_mensaje_movimiento_texto'] : ''),'style'=>'min-height:150px;','label'=>true,'texto'=>(LANGUAJE['dashboard']['anuncios']['moving-message'][CONFIG['languaje']])]).
		'<hr><b>'.(LANGUAJE['global']['show'][CONFIG['languaje']]).'</b><div>'.
		pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_anuncio_mensaje_movimiento','texto2'=>(LANGUAJE['dashboard']['anuncios']['moving-message'][CONFIG['languaje']]),'title'=>(LANGUAJE['dashboard']['anuncios']['moving-message-title'][CONFIG['languaje']])]).' '.
		pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_anuncio_mini_banner','texto2'=>(LANGUAJE['dashboard']['anuncios']['long-image'][CONFIG['languaje']]),'title'=>(LANGUAJE['dashboard']['anuncios']['long-image-title'][CONFIG['languaje']])]).' '.
		pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['nameidclass'=>'mostrar_anuncio_miniatura_article','texto2'=>(LANGUAJE['dashboard']['anuncios']['article-thumbnail'][CONFIG['languaje']]),'title'=>(LANGUAJE['dashboard']['anuncios']['article-thumbnail-title'][CONFIG['languaje']])]).'<hr>'.
		pInput(['type'=>'submit','class'=>'boton','name'=>'procesa_'.$Apartado,'value'=>(LANGUAJE['global']['update'][CONFIG['languaje']])]).
		'</div>'.'<hr>';
		?>
		<?= SCRIPTS->xv($Apartado) ?>
	</form>
</section>