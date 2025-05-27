<?php
$LISTA_DATOS_POST = [
	'scripts_google','scripts_font_awesome','scripts_otros',
];

foreach ($LISTA_DATOS_POST as $key => $value) {
	if(isset($_POST[$value]) && !empty($_POST[$value])){
		file_put_contents($Web["directorio"].'database/files/html/'.$value.'.html', trim($_POST[$value]));
	} else {
		if(file_exists($Web["directorio"].'database/files/html/'.$value.'.html')){
			unlink($Web["directorio"].'database/files/html/'.$value.'.html');
		}
	}
}

$LISTA_DATOS_POST = [
	'mostrar_scripts_google','mostrar_scripts_font_awesome',
	'mostrar_scripts_otros',
];

$DATOS_DEFAULT = true;