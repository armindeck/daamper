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
		sendAlert->Error(Language(['creator', 'please-select-a-reference'], 'dashboard'), "../admin.php?ap=creator&creador={$AC_FORMULARIO['creador']}");
	} else {
		sendAlert->Error(Language(['creator', 'please-select-a-reference'], 'dashboard'), "../admin.php?ap=creator&creador={$ACR_FORMULARIO['creador']}&tipo={$ACR_FORMULARIO['pubo']}&archivo={$ACR_FORMULARIO['db_archivo']}");
	}
}


if(file_exists(RAIZ . 'database/post/'.$AC_FORMULARIO['referencia'])){
	$ACR = DATA->Post($AC_FORMULARIO['referencia'])["ACR"];
	$AC = DATA->Post($AC_FORMULARIO['referencia'])["AC"];
} else {
	if(!$Post['existe_el_archivo_creador']){
		sendAlert->Error(Language(['creator', 'reference-does-not-exist'], 'dashboard'), "../admin.php?ap=creator&creador={$AC_FORMULARIO['creador']}");
	} else {
		sendAlert->Error(Language(['creator', 'reference-does-not-exist'], 'dashboard'), "../admin.php?ap=creator&creador={$ACR_FORMULARIO['creador']}&tipo={$ACR_FORMULARIO['pubo']}&archivo={$ACR_FORMULARIO['db_archivo']}");
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