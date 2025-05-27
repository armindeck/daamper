<?php global $AXR, $AX;
if(
	$Web['ruta_completa'] != '../../admin/process/creator.php' &&
	isset($_SESSION['tmpForm']['instance_destroy'])
	){
		unset($_SESSION['tmpForm']);
}

if(file_exists(__DIR__."/main/{$AXR['creador']}-view.php")){ Views("main/{$AXR['creador']}"); }
Show(isset($_SESSION["id"]) && isset($_GET["cerrar-sesion"]), fn() => Views("components/alert-pin"));
Views("main/auth");
Views("main/perfil");
Views("main/reportar");
Ruta(null, "./search.php", fn () => Views("main/search"));
if($Web['ruta_completa'] == '../admin/admin.php'){
	Views("main/admin");
}

if($Web['ruta_completa'] != '../../admin/process/creator.php'){
	/* Error x1 ~ admin/procesa/creator.php */
	/* Error se resetea el contenido de los formularios */
	unset($_SESSION['tmpForm']);
}