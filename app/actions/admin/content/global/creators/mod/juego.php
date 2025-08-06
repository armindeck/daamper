<?php
$MOD=['titulo_normal','descripcion','meta_descripcion','meta_etiquetas','comentar','comentarios','anuncio','catalogo'];
$AC['titulo_normal'] = $AC['titulo'];
$AC['descripcion'] = $AC['sinopsis'];
$AC['meta_descripcion'] = $AC['sinopsis'];
require __DIR__.'/../script/juego.php';
$descarga_para = ''; $descarga_para_solo = '';
foreach ($lista_os  as $os) { $os_name = Daamper::$scripts->archivoAceptado($os);
	if (isset($AC["os_{$os_name}"]) && !empty($AC["os_{$os_name}"])) {
		$descarga_para .= Language(['creator', 'other', 'juego', 'title'], 'dashboard', ['name' => $AC['titulo'], 'os' => $os]).", ";
		$descarga_para_solo .= "$os - ";
	}
}
$descarga_para_solo = substr($descarga_para_solo, 0, strlen($descarga_para_solo) - 3);
$AC['titulo'] = Language(['creator', 'other', 'juego', 'title'], 'dashboard', ['name' => $AC['titulo'], 'os' => $descarga_para_solo]);
$AC['meta_etiquetas'] = $descarga_para . ($AC['otros_nombres'] ?? '') . ", " . $AC['titulo'];
$AC['comentar']='on';
$AC['comentarios']='on';
$AC['anuncio']='';
$AC['catalogo']='Juego';
