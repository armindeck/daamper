<?php $Web['ruta_completa'] = $Web['directorio'].$Web['ruta'];

foreach ([
	'config',
	'anuncios',
	'scripts_js',
	'redes_sociales',
	'plantilla'
	] as $value) {
	$data_file = "{$Web['directorio']}panel/app/{$value}/web-{$value}.php";
	if(file_exists($data_file)){
		if (in_array($value, ['plantilla'])){
			$Web[$value] = require $data_file;
		} else {
			require $data_file;
		}
	}
} unset($data_file);

if(
	file_exists($Web['directorio'].'panel/app/plantilla/web-plantilla-scripts.php') &&
	isset($Web['plantilla']['cargar_scripts']) && !empty($Web['plantilla']['cargar_scripts'])
	){
	if(isset($Web['plantilla']['cargar_scripts_errores']) &&
		empty($Web['plantilla']['cargar_scripts_errores']) or
		!isset($Web['plantilla']['cargar_scripts_errores'])){
		$Web['plantilla']['scr'] = require_once $Web['directorio'].'panel/app/plantilla/web-plantilla-scripts.php';
	}
} ?>