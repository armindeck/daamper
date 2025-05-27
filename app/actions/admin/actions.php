<?php
/* Versions
→ v0.2 BETA 23.05.2025
→ v0.1 BETA 09.07.2024
*/
$Web=['directorio'=>'../../','ruta'=>'admin/process/admin.php'];
require_once $Web['directorio'].'app/controller/admin.php';
$LISTA_POST=['scripts', 'htaccess', 'ads', 'config', 'upload-image', 'theme', 'users', 'template', 'comments'];

foreach ($LISTA_POST as $key => $value) {
	if(isset($_POST['procesa_'.$value]) && !empty($_POST['procesa_'.$value])){
		$Apartado=$value; break;
	}
} unset($LISTA_POST);
if(!isset($Apartado)){
	sendAlert->Warning(Language('no-access-file'), "../admin.php");
}

$rules_admin = DATA->Config("rules")["admin"];
if (!isset($rules_admin[strtolower($_SESSION["rol"])]) || !in_array($Apartado, $rules_admin[strtolower($_SESSION["rol"])])){
	sendAlert->Success(Language(['dashboard', 'higher-role-required'], 'dashboard'), "../admin.php");
}

if($Apartado == "upload-image"){
	$tipo_de_seccion = "admin";
	require __DIR__ . "/../components/upload-image.php";
} elseif(file_exists(__DIR__."/content/$Apartado.php")){
	require __DIR__."/content/$Apartado.php";
} else {
	sendAlert->Success(Language('file-not-exist-section'), "../admin.php?ap=$Apartado");
}

if(isset($DATOS_DEFAULT) && $DATOS_DEFAULT){
	if(!isset($LISTA_DATOS_POST)){
		sendAlert->Success(Language('data-list-not-exist'), "../admin.php?ap=$Apartado");
	}

	unset($post); unset($guardar);
	$post=[];	
	foreach ($LISTA_DATOS_POST as $key => $value) {
		if(!isset($_POST[$value])){ $_POST[$value]=''; }
		$post[$value]=SCRIPTS->normalizar2($_POST[$value]);
	}

	if ($Apartado == 'config') {
		if (!isset($post['language']) || empty($post['language'])){
			$post['language'] = 'es';
		}
	}
	if (in_array($Apartado, ["scripts", "htaccess", "ads", "config"])){
		SCRIPTS->CrearCarpetas("database/config/");
		$final = DATA->Config();
		$final[$Apartado] = $post;
		$confirmar = DATA->Save("config/config", $final);
	} else {
		SCRIPTS->CrearCarpetas("database/$Apartado/");
		$confirmar = DATA->Save("$Apartado/$Apartado", $post);
	}
	if($confirmar){
		sendAlert->Success(Language('data-save'), "../admin.php?ap=$Apartado");
	} else {
		sendAlert->Success(Language('data-no-save'), "../admin.php?ap=$Apartado");
	}
}

sendAlert->Warning(Language('cannot-stay-here'), "../admin.php?ap=$Apartado");