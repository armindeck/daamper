<?php # v0.1 BETA 30.11.2024
$Web=['directorio'=>'../../','ruta'=>'panel/procesa/procesa.panel.php'];
require_once $Web['directorio'].'app/control/control_procesa.php';
$Apartado='plantilla';

if(
	!isset($_POST['procesa_'.$Apartado]) && empty($_POST['procesa_'.$Apartado])
){
	mensajeSpan(['bg'=>'yellow', 'co'=>'#000','text'=>Language('no-access-file'),'ruta'=>"../panel.php"]);
}

if(file_exists('../app/'.$Apartado.'/procesa.php')){
	require '../app/'.$Apartado.'/procesa.php';
} else {
	mensajeSpan(['bg'=>'red','text'=>Language('file-not-exist-section'),'ruta'=>"../panel.php?ap=$Apartado"]);
}

mensajeSpan(['bg'=>'yellow', 'co'=>'#000','text'=>Language('cannot-stay-here'),'ruta'=>"../panel.php?ap=$Apartado"]);
?>