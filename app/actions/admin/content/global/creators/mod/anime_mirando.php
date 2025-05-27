<?php
$AC2=$AC; $ACR2=$ACR;
if(!file_exists(RAIZ . 'database/post/'.$AC['referencia'])){
	die(Language(['creator', 'reference-does-not-exist'], 'dashboard'));
}

$ACR = DATA->Post($AC['referencia'])["ACR"];
$AC = DATA->Post($AC['referencia'])["AC"];

require __DIR__.'/anime_entrada.php';
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
$AC['titulo'] = Language(['creator', 'other', 'anime_mirando', 'title'], 'dashboard', ['value' => $AC['titulo_normal'], 'episode' => $AC['episodio']]);
$AC['descripcion'] = Language(['creator', 'other', 'anime_mirando', 'description'], 'dashboard', ['name' => $AC['titulo_normal'], 'episode' => $AC['episodio'], 'webname' => $Web['config']['nombre_web']]);
$AC['meta_descripcion'] = $AC['descripcion'];
$AC['meta_etiquetas'] = Language(['creator', 'other', 'anime_mirando', 'tags'], 'dashboard', ['name' => $AC['titulo_normal'], 'title' => $AC['titulo'], 'episode' => $AC['episodio']]);
$AC['comentar'] = 'on';
$AC['comentarios'] = 'on';
$AC['anuncio'] = 'on';
