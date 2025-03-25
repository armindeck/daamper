<?php global $AXR, $AX;
if(
	$Web['ruta_completa'] != '../../panel/procesa/procesa.creador.borrador.php' &&
	isset($_SESSION['tmpForm']['instance_destroy'])
	){
		unset($_SESSION['tmpForm']);
}

# Views del apartado creador en los creadores
if(file_exists("{$Web['directorio']}panel/app/creador/creadores/{$AXR['creador']}/view.php")){
	require "{$Web['directorio']}panel/app/creador/creadores/{$AXR['creador']}/view.php";
}

Views("main/auth");
Views("main/perfil");
Views("main/reportar");

if($Web['ruta_completa'] == '../panel/panel.php'){
	Views("main/panel");
}

if($Web['ruta_completa'] != '../../panel/procesa/procesa.creador.borrador.php'){
	/* Error x1 ~ panel/procesa/procesa.creador.borrador.php */
	/* Error se resetea el contenido de los formularios */
	unset($_SESSION['tmpForm']);
}

?>