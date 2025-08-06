<?php require_once __DIR__ . '/adaptabilidad.php';
$ruta_publicaciones_json = str_replace(".php", ".json", Daamper::$scripts->eslasToGuion($Web['ruta']));
$ruta_publicaciones = RAIZ . 'database/post/' . $ruta_publicaciones_json;
if(file_exists($ruta_publicaciones)){
	$ACR = Daamper::$data->Post($ruta_publicaciones_json)["ACR"] ?? [];
	$AC = Daamper::$data->Post($ruta_publicaciones_json)["AC"] ?? [];
	if(!isset($ACR['creador'])){ die(Language('file-no-identifier', 'alert')); }
} else {
	if(substr($Web['ruta'], 0, 2) == 'p/'){
		$ruta_perfil = RAIZ . 'database/post/p-perfil.json';
		if(file_exists($ruta_perfil)){
			$ACR = Daamper::$data->Post("p-perfil")["ACR"] ?? [];
			$AC = Daamper::$data->Post("p-perfil")["AC"] ?? [];
			} else { die(Language('profile-data-missing', 'alert')); }
	} else { die(Language('data-file-missing', 'alert')); }
}

if(!file_exists(RAIZ . "app/views/admin/creators/{$ACR['creador']}-view.php")){ die(Language('creator-not-found', 'alert', ['value' => "<strong>{$ACR['creador']}</strong>"])); }

$ruta_creadores_mod = RAIZ . "app/actions/admin/content/global/creators/mod/{$ACR['creador']}.php";
if(file_exists($ruta_creadores_mod)){
	require $ruta_creadores_mod;
	if(isset($ACMOD)){ foreach ($ACMOD as $key => $value) { $AC[$key] = $value; } }
}

foreach ($AC as $key => $value) { $AX[$key] = $value; } $AXR = $ACR;

unset($ruta_creadores_mod); unset($ruta_publicaciones); unset($ruta_publicaciones_json); unset($ruta_perfil);
unset($ACR); unset($AC); unset($ACMOD);