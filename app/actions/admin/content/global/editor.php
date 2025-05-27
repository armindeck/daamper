<?php

if(isset($_GET['dir'])){
	$Panel['ap_directorio_dir'] = SCRIPTS->normalizar2($_GET['dir']);
} else {
	sendAlert->Error(Language(['editor', 'file-required'], 'dashboard'), "?ap=directory&dir=../");
}

if(!isset($_GET['crear'])){
	if(is_dir($Panel['ap_directorio_dir'])){
		sendAlert->Error(Language(['editor', 'only-edit-files'], 'dashboard'), "?ap=directory&dir=".$Panel['ap_directorio_dir']);
	}
	if(!file_exists($Panel['ap_directorio_dir']) && !isset($_GET['permiso'])){
		sendAlert->Error(Language('file-no-exists', 'global', ['value'=> '<strong>'.basename($Panel['ap_directorio_dir']).'</strong>']), "?ap=directory&dir=".dirname($Panel['ap_directorio_dir'])."/");
	}
	$Panel['ap_directorio_dir_completo']=$Panel['ap_directorio_dir'];
} else {
	if(!is_dir($Panel['ap_directorio_dir']) or is_dir($Panel['ap_directorio_dir'].$_GET['crear'])){
		sendAlert->Error(Language(['editor', 'only-edit-files'], 'dashboard'), "?ap=directory&dir=".$Panel['ap_directorio_dir']);
	}
}
if(isset($_GET['crear'])){ $Panel['get_crear'] = SCRIPTS->normalizar2($_GET['crear']); }

if(isset($Panel['get_crear'])){
	if(file_exists($Panel['ap_directorio_dir'].$Panel['get_crear'])){
		sendAlert->Error(Language('file-exists', 'global', ['value' => '<strong>'.$Panel['get_crear'].'</strong>']), "?ap=editor&dir=".$Panel['ap_directorio_dir'].$Panel['get_crear']);
	} else {
		$Panel['ap_directorio_dir_completo']=$Panel['ap_directorio_dir'].$Panel['get_crear'];
	}
}
?>

<?php
$permisos_get = explode('/', $Panel['ap_directorio_dir_completo']);
if(count($permisos_get)>2){
	$permisos_get_conver = $permisos_get[0].'/'.$permisos_get[1].'/'.$permisos_get[2];
	if($permisos_get_conver=='../admin/app' && !isset($_GET['permiso']) && $_SESSION['rol'] != 'CEO Founder'){
		sendAlert->Warning(Language(['editor', 'file-no-permission'], 'dashboard'), "?ap=directory&dir=".dirname($Panel['ap_directorio_dir']).'/');
	}
}

if(dirname($Panel['ap_directorio_dir_completo'])=='../app/system' && $_SESSION['rol'] != 'CEO Founder'){
	sendAlert->Warning(Language(['editor', 'file-no-permission'], 'dashboard'), "?ap=directory&dir=".dirname($Panel['ap_directorio_dir']).'/');
}
?>

<?php $routehistoritxt = "database/files/txt/history/editor/";
SCRIPTS->CrearCarpetas($routehistoritxt);

if(isset($_POST['guardar']) && !empty($_POST['guardar'])){
	file_put_contents($Panel['ap_directorio_dir_completo'], trim($_POST['contenido']));
	if(!file_exists(
		$Web["directorio"].$routehistoritxt.
		SCRIPTS->eslasToGuion(
			SCRIPTS->quitarPuntoEslas(
				$Panel['ap_directorio_dir_completo'].'.txt'
			)
		)
	)){
		file_put_contents(
			$Web["directorio"].$routehistoritxt.
			SCRIPTS->eslasToGuion(
				SCRIPTS->quitarPuntoEslas(
					$Panel['ap_directorio_dir_completo'].'.txt'
				)
			),
			'Generado: ' . SCRIPTS->fecha_hora() . ' -> ' . $_SESSION['id']
		);
	}
	file_put_contents($Web["directorio"].$routehistoritxt.SCRIPTS->eslasToGuion(SCRIPTS->quitarPuntoEslas($Panel['ap_directorio_dir_completo'].'.txt')), SCRIPTS->fecha_hora() ." ~ Modificado -> ".$_SESSION['id']."\n".file_get_contents($Web["directorio"].$routehistoritxt.SCRIPTS->eslasToGuion(SCRIPTS->quitarPuntoEslas($Panel['ap_directorio_dir_completo'].'.txt'))));

	sendAlert->Success(Language('file-save', 'global', ['value' => '<strong>'.basename($Panel['ap_directorio_dir_completo']).'</strong>']), "?ap=editor&dir={$Panel['ap_directorio_dir_completo']}");
}

if(isset($_POST['eliminar_archivo_boton']) && !empty($_POST['eliminar_archivo_boton'])){
	if($_POST['confirmar']!='Si'){
		sendAlert->Error(Language(['editor', 'confirm-delete'], 'dashboard'), "?ap=editor&dir={$Panel['ap_directorio_dir_completo']}");
	}
	if(file_exists($Panel['ap_directorio_dir_completo'])){
		unlink($Panel['ap_directorio_dir_completo']);
		file_put_contents($Web["directorio"].$routehistoritxt.SCRIPTS->eslasToGuion(SCRIPTS->quitarPuntoEslas($Panel['ap_directorio_dir_completo'].'.txt')), SCRIPTS->fecha_hora() ." ~ Eliminado -> ".$_SESSION['id']."\n".file_get_contents($Web["directorio"].$routehistoritxt.SCRIPTS->eslasToGuion(SCRIPTS->quitarPuntoEslas($Panel['ap_directorio_dir_completo'].'.txt'))));
		if(dirname($Panel['ap_directorio_dir_completo'])=='..'){
			$dir_eliminado = '../';
		} else {
			$dir_eliminado = dirname($Panel['ap_directorio_dir_completo']).'/';
		}
		sendAlert->Success(Language('file-delete', 'global', ['value' => '<strong>'.basename($Panel['ap_directorio_dir_completo']).'</strong>']), "?ap=directory&dir=".$dir_eliminado);
	} else {
		sendAlert->Error(Language(['directory', 'directory-no-exists'], 'dashboard'), "?ap=editor&dir={$Panel['ap_directorio_dir_completo']}");
	}
}
