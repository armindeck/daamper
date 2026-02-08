<?php
/* Versions
→ v0.3 BETA 04.02.2026
→ v0.2.1 BETA 05.11.2025
→ v0.2 BETA 23.05.2025
→ v0.1 BETA 09.07.2024
*/
$Web=['directorio'=>'../../','ruta'=>'admin/process/admin.php'];
require_once $Web['directorio'].'app/controller/admin.php';
$LISTA_POST=['scripts', 'htaccess', 'ads', 'config', 'upload-image', 'users', 'template', 'comments'];

foreach ($LISTA_POST as $key => $value) {
	if(isset($_POST['procesa_'.$value]) && !empty($_POST['procesa_'.$value])){
		$Apartado=$value; break;
	}
} unset($LISTA_POST);
if(!isset($Apartado)){
	Daamper::$sendAlert->Warning(Language('no-access-file'), "../admin.php");
}

$rules_admin = Daamper::$data->Config("admin")["rules"];
if (!isset($rules_admin[strtolower($_SESSION["rol"])]) || !in_array($Apartado, $rules_admin[strtolower($_SESSION["rol"])])){
	Daamper::$sendAlert->Success(Language(['dashboard', 'higher-role-required'], 'dashboard'), "../admin.php");
}

if($Apartado == "upload-image"){
	$tipo_de_seccion = "admin";
	require __DIR__ . "/../components/upload-image.php";
} elseif(file_exists(__DIR__."/content/$Apartado.php")){
	require __DIR__."/content/$Apartado.php";
} else {
	$Apartado = $Apartado == "htaccess" ? "config" : $Apartado;
	Daamper::$sendAlert->Warning(Language('file-not-exist-section'), "../admin.php?ap=$Apartado");
}

if(isset($DATOS_DEFAULT) && $DATOS_DEFAULT){
	if(!isset($LISTA_DATOS_POST)){
		$Apartado = $Apartado == "htaccess" ? "config" : $Apartado;
		Daamper::$sendAlert->Error(Language('data-list-not-exist'), "../admin.php?ap=$Apartado");
	}

	unset($post); unset($guardar);
	$post=[];	
	foreach ($LISTA_DATOS_POST as $key => $value) {
		if(!isset($_POST[$value])){ $_POST[$value] = ''; }
		if(!empty($LISTA_DATOS_POST_ESCAPE_CONVERT) && in_array($value, $LISTA_DATOS_POST_ESCAPE_CONVERT)){
			$post[$value] = $_POST[$value];
		} else {
			$post[$value] = Daamper::$scripts->normalizar2($_POST[$value]);
		}
	}

	if ($Apartado == 'config') {
		if (!isset($post['language']) || empty($post['language'])){
			$post['language'] = 'es';
		}
	}
	if (in_array($Apartado, ["scripts", "htaccess", "ads", "config"])){
		Daamper::$scripts->CrearCarpetas("database/config/");
		$final = Daamper::$data->Config();
		$final[$Apartado] = $post;
		$confirmar = Daamper::$data->Save("config/config", $final);
	} else {
		Daamper::$scripts->CrearCarpetas("database/$Apartado/");
		$confirmar = Daamper::$data->Save("$Apartado/$Apartado", $post);
	}
	$Apartado = $Apartado == "htaccess" ? "config" : $Apartado;
	if($confirmar){
		Daamper::$sendAlert->Success(Language('data-save'), "../admin.php?ap=$Apartado");
	} else {
		Daamper::$sendAlert->Error(Language('data-no-save'), "../admin.php?ap=$Apartado");
	}
}
$Apartado = $Apartado == "htaccess" ? "config" : $Apartado;
Daamper::$sendAlert->Warning(Language('cannot-stay-here'), "../admin.php?ap=$Apartado");