<?php

$AC2=$AC; $ACR2=$ACR;
if(!file_exists($Web['directorio'].'app/database/publicaciones/'.$AC['referencia'])){
	die(Language(['creador', 'reference-does-not-exist'], 'dashboard'));
}

require $Web['directorio'].'app/database/publicaciones/'.$AC['referencia'];

require $Web['directorio'].'panel/app/creador/creadores/anime_entrada/mod.php';
$MOD = [
	'titulo','descripcion','meta_descripcion','meta_etiquetas'
];

foreach ($MOD as $key => $value) { $AC2[$value] = $AC[$value]; }
	
$AC2['ruta_referencia'] = $AC['ruta'];
$AC2['archivo_referencia'] = $AC['archivo'];
unset($AC); unset($ACR);

$ACR = $ACR2; $AC = $AC2;
unset($AC2); unset($ACR2);

$AC['titulo_normal'] = $AC['titulo'];
$AC['titulo'] = Language(['creador', 'other', 'anime_mirando', 'title'], 'dashboard', ['value' => $AC['titulo_normal'], 'episode' => $AC['episodio']]);
$AC['descripcion'] = Language(['creador', 'other', 'anime_mirando', 'description'], 'dashboard', ['name' => $AC['titulo_normal'], 'episode' => $AC['episodio'], 'webname' => $Web['config']['nombre_web']]);
$AC['meta_descripcion'] = $AC['descripcion'];
$AC['meta_etiquetas'] = Language(['creador', 'other', 'anime_mirando', 'tags'], 'dashboard', ['name' => $AC['titulo_normal'], 'title' => $AC['titulo'], 'episode' => $AC['episodio']]);
$AC['comentar'] = 'on';
$AC['comentarios'] = 'on';
$AC['anuncio'] = 'on';
?>