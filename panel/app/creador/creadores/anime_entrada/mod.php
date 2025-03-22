<?php
$MOD=['titulo_normal','descripcion','meta_descripcion','meta_etiquetas','comentar','comentarios','anuncio'];
$AC['titulo_normal'] = $AC['titulo'];
$AC['descripcion'] = $AC['sinopsis'];
$AC['meta_descripcion'] = $AC['sinopsis'];
$AC['meta_etiquetas'] = $AC['titulo'].', Todos los capitulos de '.$AC['titulo'].', Ver y descargar todos los capitulos de '.$AC['titulo'].' en HD - '.$Web['config']['nombre_web'];
$AC['comentar']='on';
$AC['comentarios']='on';
$AC['anuncio']='';
?>