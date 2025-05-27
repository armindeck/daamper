<?php
$MOD=['titulo_normal','descripcion','meta_descripcion','meta_etiquetas','comentar','comentarios','anuncio'];
$AC['titulo_normal'] = $AC['titulo'];
$AC['descripcion'] = $AC['sinopsis'];
$AC['meta_descripcion'] = $AC['sinopsis'];
$AC['meta_etiquetas'] = Language(['creator', 'other', 'anime_entrada', 'tags'], 'dashboard', ['value' => $AC['titulo']]);
$AC['comentar']='on';
$AC['comentarios']='on';
$AC['anuncio']='';
?>