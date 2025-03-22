<?php

$AC2=$AC; $ACR2=$ACR;
if(!file_exists($Web['directorio'].'app/database/publicaciones/'.$AC['referencia'])){
	die('No existe la referencia.');
}

require $Web['directorio'].'app/database/publicaciones/'.$AC['referencia'];

require $Web['directorio'].'panel/app/creador/creadores/anime_entrada/mod.php';
$MOD = [
	'titulo','descripcion','meta_descripcion','meta_etiquetas'
];

foreach ($MOD as $key => $value) { $AC2[$value] = $AC[$value]; }
	
$AC2['ruta_referencia']=$AC['ruta'];
$AC2['archivo_referencia']=$AC['archivo'];
unset($AC); unset($ACR);

$ACR=$ACR2; $AC=$AC2;
unset($AC2); unset($ACR2);

$AC['titulo_normal']=$AC['titulo'];
$AC['titulo']=$AC['titulo_normal'].' episodio '.$AC['episodio'];
$AC['descripcion']='Ver y descargar '.$AC['titulo_normal'].' episodio '.$AC['episodio'].' por '.$Web['config']['nombre_web'];
$AC['meta_descripcion']=$AC['descripcion'];
$AC['meta_etiquetas']=$AC['titulo_normal'].', '.$AC['titulo'].', Ver '.$AC['titulo_normal'].' episodio '.$AC['episodio'].' online en HD, descargar episodio '.$AC['episodio'].' de '.$AC['titulo_normal'].', descargar episodio '.$AC['episodio'].' de '.$AC['titulo_normal'].' por MEGA y MediaFire - '.$Web['config']['nombre_web'];
$AC['comentar']='on';
$AC['comentarios']='on';
$AC['anuncio'] = 'on';
?>