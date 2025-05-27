<?php # admin
Ruta(null, "../admin/index.php", function () use ($Web) {
	if(!isset($_SESSION['id']) || !isset($_SESSION['rol'])){
		sendAlert->Error(Language('login-required', 'alert'), "{$Web['directorio']}auth/login{$Web['config']['php']}");
	}
	header("Location: {$Web['directorio']}admin/admin.php");
});

Ruta(null, "../admin/admin.php", function () use ($Web) {
	if(!isset($_SESSION['id']) || !isset($_SESSION['rol'])){
		sendAlert->Error(Language('login-required', 'alert'), "{$Web['directorio']}auth/login{$Web['config']['php']}");
	}

  if (strtolower($_SESSION['rol']) == 'usuario'){
  	sendAlert->Warning(Language('higher-role-required', 'alert'), $Web['directorio']);
  }
});

if($Web['ruta_completa'] == '../admin/admin.php' && isset($_GET['ap'])){
	$rules_admin = DATA->Config("rules")["admin"];
	if (isset($rules_admin[strtolower($_SESSION["rol"])]) && in_array($_GET['ap'], $rules_admin[strtolower($_SESSION["rol"])])){
		if(in_array($_GET['ap'], ['creator', 'directory', 'editor', 'theme', 'template'])){
			if(file_exists($Web['directorio'].'app/actions/admin/content/global/'.SCRIPTS->normalizar($_GET['ap']).'.php')){
				require_once $Web['directorio'].'app/actions/admin/content/global/'.SCRIPTS->normalizar($_GET['ap']).'.php';
			}
		}
	} elseif(file_exists(RAIZ . "app/views/admin/" . $_GET["ap"] . "-view.php")) {
		sendAlert->Error(Language(['dashboard', 'higher-role-required'], 'dashboard'), "admin.php");
	}
}
