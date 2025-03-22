<?php

if(isset($_GET['dir'])){
	$Panel['ap_directorio_dir'] = SCRIPTS->normalizar2($_GET['dir']);
} else {
	mensajeSpan(['bg'=>'red','text'=>LANGUAJE['dashboard']['editor']['file-required'][CONFIG['languaje']],'ruta'=>"?ap=directorio&dir=../"]);
}

if(!isset($_GET['crear'])){
	if(is_dir($Panel['ap_directorio_dir'])){
		mensajeSpan(['bg'=>'red','text'=>LANGUAJE['dashboard']['editor']['only-edit-files'][CONFIG['languaje']],'ruta'=>"?ap=directorio&dir=".$Panel['ap_directorio_dir']]);
	}
	if(!file_exists($Panel['ap_directorio_dir']) && !isset($_GET['permiso'])){
		mensajeSpan(['bg'=>'red','text'=>(LANGUAJE['global']['file-no-exists'][CONFIG['languaje']][0]).' <strong>'.basename($Panel['ap_directorio_dir']).'</strong> '.(LANGUAJE['global']['file-no-exists'][CONFIG['languaje']][1]),'ruta'=>"?ap=directorio&dir=".dirname($Panel['ap_directorio_dir'])]);
	}
	$Panel['ap_directorio_dir_completo']=$Panel['ap_directorio_dir'];
} else {
	if(!is_dir($Panel['ap_directorio_dir']) or is_dir($Panel['ap_directorio_dir'].$_GET['crear'])){
		mensajeSpan(['bg'=>'red','text'=>LANGUAJE['dashboard']['editor']['only-edit-files'][CONFIG['languaje']],'ruta'=>"?ap=directorio&dir=".$Panel['ap_directorio_dir']]);
	}
}
if(isset($_GET['crear'])){ $Panel['get_crear'] = SCRIPTS->normalizar2($_GET['crear']); }

if(isset($Panel['get_crear'])){
	if(file_exists($Panel['ap_directorio_dir'].$Panel['get_crear'])){
		mensajeSpan(['bg'=>'red','text'=>(LANGUAJE['global']['file-exists'][CONFIG['languaje']][0]).' <strong>'.$Panel['get_crear'].'</strong> '.(LANGUAJE['global']['file-no-exists'][CONFIG['languaje']][1]),'ruta'=>"?ap=editor&dir=".$Panel['ap_directorio_dir'].$Panel['get_crear']]);
	} else {
		$Panel['ap_directorio_dir_completo']=$Panel['ap_directorio_dir'].$Panel['get_crear'];
	}
}
?>

<?php
$permisos_get = explode('/', $Panel['ap_directorio_dir_completo']);
if(count($permisos_get)>2){
	$permisos_get_conver = $permisos_get[0].'/'.$permisos_get[1].'/'.$permisos_get[2];
	if($permisos_get_conver=='../panel/app' && !isset($_GET['permiso']) && $_SESSION['rol'] != 'CEO Founder'){
		mensajeSpan(['bg'=>'yellow','co'=>'#000','text'=>LANGUAJE['dashboard']['editor']['file-no-permission'][CONFIG['languaje']],'ruta'=>"?ap=directorio&dir=".dirname($Panel['ap_directorio_dir']).'/']);
	}
}

if(dirname($Panel['ap_directorio_dir_completo'])=='../app/system' && $_SESSION['rol'] != 'CEO Founder'){
	mensajeSpan(['bg'=>'yellow','co'=>'#000','text'=>LANGUAJE['dashboard']['editor']['file-no-permission'][CONFIG['languaje']],'ruta'=>"?ap=directorio&dir=".dirname($Panel['ap_directorio_dir']).'/']);
}
?>

<?php
if(!file_exists(__DIR__.'/historial/')){
	if(!mkdir(__DIR__.'/historial/', 0777, true));
}

if(isset($_POST['guardar']) && !empty($_POST['guardar'])){
	file_put_contents($Panel['ap_directorio_dir_completo'], trim($_POST['contenido']));
	if(!file_exists(
		__DIR__.'/historial/'.
		SCRIPTS->eslasToGuion(
			SCRIPTS->quitarPuntoEslas(
				$Panel['ap_directorio_dir_completo'].'.txt'
			)
		)
	)){
		file_put_contents(
			__DIR__.'/historial/'.
			SCRIPTS->eslasToGuion(
				SCRIPTS->quitarPuntoEslas(
					$Panel['ap_directorio_dir_completo'].'.txt'
				)
			),
			'Generado: ' . SCRIPTS->fecha_hora() . ' -> ' . $_SESSION['id']
		);
	}
	file_put_contents(__DIR__.'/historial/'.SCRIPTS->eslasToGuion(SCRIPTS->quitarPuntoEslas($Panel['ap_directorio_dir_completo'].'.txt')), SCRIPTS->fecha_hora() ." ~ Modificado -> ".$_SESSION['id']."\n".file_get_contents(__DIR__.'/historial/'.SCRIPTS->eslasToGuion(SCRIPTS->quitarPuntoEslas($Panel['ap_directorio_dir_completo'].'.txt'))));

	mensajeSpan(['bg'=>'green','text'=>(LANGUAJE['global']['file-save'][CONFIG['languaje']][0]).' <strong>'.basename($Panel['ap_directorio_dir_completo']).'</strong> ' . (LANGUAJE['global']['file-save'][CONFIG['languaje']][1]),'ruta'=>"?ap=editor&dir={$Panel['ap_directorio_dir_completo']}"]);
}

if(isset($_POST['eliminar_archivo_boton']) && !empty($_POST['eliminar_archivo_boton'])){
	if($_POST['confirmar']!='Si'){
		mensajeSpan(['bg'=>'red','text'=>(LANGUAJE['dashboard']['directorio']['confirm-delete'][CONFIG['languaje']]),'ruta'=>"?ap=editor&dir={$Panel['ap_directorio_dir_completo']}"]);
	}
	if(file_exists($Panel['ap_directorio_dir_completo'])){
		unlink($Panel['ap_directorio_dir_completo']);
		file_put_contents(__DIR__.'/historial/'.SCRIPTS->eslasToGuion(SCRIPTS->quitarPuntoEslas($Panel['ap_directorio_dir_completo'].'.txt')), SCRIPTS->fecha_hora() ." ~ Eliminado -> ".$_SESSION['id']."\n".file_get_contents(__DIR__.'/historial/'.SCRIPTS->eslasToGuion(SCRIPTS->quitarPuntoEslas($Panel['ap_directorio_dir_completo'].'.txt'))));
		if(dirname($Panel['ap_directorio_dir_completo'])=='..'){
			$dir_eliminado = '../';
		} else {
			$dir_eliminado = dirname($Panel['ap_directorio_dir_completo']).'/';
		}
		mensajeSpan(['bg'=>'green','text'=>(LANGUAJE['global']['file-delete'][CONFIG['languaje']][0]).' <strong>'.basename($Panel['ap_directorio_dir_completo']).'</strong>'.(LANGUAJE['global']['file-delete'][CONFIG['languaje']][1]),'ruta'=>"?ap=directorio&dir=".$dir_eliminado]);
	} else {
		mensajeSpan(['bg'=>'red','text'=>LANGUAJE['dashboard']['directorio']['directory-no-exists'][CONFIG['languaje']],'ruta'=>"?ap=editor&dir={$Panel['ap_directorio_dir_completo']}"]);
	}
}

?>