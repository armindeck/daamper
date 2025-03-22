<?php
/*
DATOS DEL CREADOR -> POR FAVOR SOLO USAR SI ES TAN NECESARIO.
	$ACR_FORM | $AC_FORM

DATOS EXTRAIDOS DEL FORMULARIO -> PUEDEN USAR ESTE LIBREMENTE:
	$ACR_FORMULARIO -> datos del creador:
			-> creador, tipo, db_archivo
	$AC_FORMULARIO -> datos del formulario creado:
			-> titulo, descripcion, miniatura...
*/

$Post['existe_el_archivo_creador']=false;
if(!empty($ACR_FORMULARIO['pubo'])){
	$Post['existe_el_archivo_creador']=true;
}
if (empty($AC_FORMULARIO['referencia'])) {
	if(!$Post['existe_el_archivo_creador']){
		mensajeSpan(['bg'=>'red','text'=>'Por favor seleccione una referencia.','ruta'=>"../panel.php?ap=creador&creador={$AC_FORMULARIO['creador']}"]);
	} else {
		mensajeSpan(['bg'=>'red','text'=>'Por favor seleccione una referencia.','ruta'=>"../panel.php?ap=creador&creador={$ACR_FORMULARIO['creador']}&tipo={$ACR_FORMULARIO['pubo']}&archivo={$ACR_FORMULARIO['db_archivo']}"]);
	}
}


if(file_exists($Web['directorio'].'app/database/publicaciones/'.$AC_FORMULARIO['referencia'])){
	require $Web['directorio'].'app/database/publicaciones/'.$AC_FORMULARIO['referencia'];
	
} else {
	if(!$Post['existe_el_archivo_creador']){
		mensajeSpan(['bg'=>'red','text'=>'Parece que la referencia no existe.','ruta'=>"../panel.php?ap=creador&creador={$AC_FORMULARIO['creador']}"]);
	} else {
		mensajeSpan(['bg'=>'red','text'=>'Parece que la referencia no existe.','ruta'=>"../panel.php?ap=creador&creador={$ACR_FORMULARIO['creador']}&tipo={$ACR_FORMULARIO['pubo']}&archivo={$ACR_FORMULARIO['db_archivo']}"]);
	}
}

$AC_FORM_POST = [
	'mostrar_en_index'=>true,
	'directorio'=>'../',
	'ruta'=>'ver/',
	'archivo'=>str_replace('.php', '', SCRIPTS->quitarEPHP($AC['archivo'])).'-'.$AC_FORMULARIO['episodio'].'.php'
];

// Se eliminan los datos cargados
unset($AC); unset($ACR);
unset($Post);
?>