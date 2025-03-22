<?php # v0.1 BETA 30.11.2024
$Web=['directorio'=>'../../','ruta'=>'panel/procesa/procesa.panel.php'];
require_once $Web['directorio'].'app/control/control_procesa.php';
$Apartado='plantilla';

if(
	!isset($_POST['procesa_'.$Apartado]) && empty($_POST['procesa_'.$Apartado])
){
	mensajeSpan(['bg'=>'yellow', 'co'=>'#000','text'=>'No tiene acceso al archivo.','ruta'=>"../panel.php"]);
}

if(file_exists('../app/'.$Apartado.'/procesa.php')){
	require '../app/'.$Apartado.'/procesa.php';
} else {
	mensajeSpan(['bg'=>'red','text'=>'No existe el archivo procesa del apartado.','ruta'=>"../panel.php?ap=$Apartado"]);
}

mensajeSpan(['bg'=>'yellow', 'co'=>'#000','text'=>'No puede seguir aquí.','ruta'=>"../panel.php?ap=$Apartado"]);
?>