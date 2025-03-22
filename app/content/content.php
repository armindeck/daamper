<?php require_once __DIR__ . '/adaptabilidad.php';
$ruta_publicaciones = $Web['directorio'].'app/database/publicaciones/pu_' . SCRIPTS->eslasToGuion($Web['ruta']);
if(file_exists($ruta_publicaciones)){ require_once $ruta_publicaciones;
	if(!isset($ACR['creador'])){ die('Este archivo no tiene un identificador o esta incompleto.'); }
} else {
	if(substr($Web['ruta'], 0, 2) == 'p/'){
		$ruta_perfil = $Web['directorio'].'app/database/publicaciones/pu_p-perfil.php';
		if(file_exists($ruta_perfil)){ require_once $ruta_perfil; }
			else { die('No existen los datos del perfil!'); }
	} else { die('No existe el archivo de los datos!'); }
}

$ruta_creadores = "{$Web['directorio']}panel/app/creador/creadores/{$ACR['creador']}/";
if(!file_exists("$ruta_creadores{$ACR['creador']}.php")){ die("El creador <strong>{$ACR['creador']}</strong> no existe."); }

if(file_exists("$ruta_creadores/mod.php")){ require "$ruta_creadores/mod.php";
	if(isset($ACMOD)){ foreach ($ACMOD as $key => $value) { $AC[$key] = $value; } }
}

foreach ($AC as $key => $value) { $AX[$key] = $value; } $AXR = $ACR;

unset($ruta_creadores); unset($ruta_publicaciones); unset($ruta_perfil);
unset($ACR); unset($AC); unset($ACMOD);
?>