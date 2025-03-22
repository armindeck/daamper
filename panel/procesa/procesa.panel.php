<?php # v0.1 BETA 09.07.2024
$Web=['directorio'=>'../../','ruta'=>'panel/procesa/procesa.panel.php'];
require_once $Web['directorio'].'app/control/control_procesa.php';
$LISTA_POST=[
	'scripts_js','htaccess','anuncios','config',
	'subir_imagen','tema','usuarios'
];

foreach ($LISTA_POST as $key => $value) {
	if(isset($_POST['procesa_'.$value]) && !empty($_POST['procesa_'.$value])){
		$Apartado=$value; break;
	}
} unset($LISTA_POST);

if(!isset($Apartado)){
	mensajeSpan(['bg'=>'yellow', 'co'=>'#000','text'=>'No tiene acceso al archivo.','ruta'=>"../panel.php"]);
}

if(file_exists('../app/'.$Apartado.'/procesa.php')){
	require '../app/'.$Apartado.'/procesa.php';
} else {
	mensajeSpan(['bg'=>'red','text'=>'No existe el archivo procesa del apartado.','ruta'=>"../panel.php?ap=$Apartado"]);
}

if(isset($DATOS_DEFAULT) && $DATOS_DEFAULT){
	if(!isset($LISTA_DATOS_POST)){
		mensajeSpan(['bg'=>'red','text'=>'No existe la lista de los datos que se van a procesar.','ruta'=>"../panel.php?ap=$Apartado"]);
	}

	unset($post); unset($guardar);
	$post=[];	
	foreach ($LISTA_DATOS_POST as $key => $value) {
		if(!isset($_POST[$value])){ $_POST[$value]=''; }
		$post[$value]=SCRIPTS->normalizar2($_POST[$value]);
	}

	$guardar = "<?php #v".SCRIPTS->xv($Apartado, null, true)."\n";
	$guardar .= '$'."Web['{$Apartado}']=[\n";
	foreach ($post as $key => $value) {
		$guardar .= "'$key' => '$value',\n";
	}
	$guardar .= "];\n?>";

	$confirmar = file_put_contents("../app/$Apartado/web-{$Apartado}.php", $guardar);
	if($confirmar){
		mensajeSpan(['bg'=>'green','text'=>'Los datos se actualizaron.','ruta'=>"../panel.php?ap=$Apartado"]);
	} else {
		mensajeSpan(['bg'=>'red','text'=>'Los datos NO se actualizaron.','ruta'=>"../panel.php?ap=$Apartado"]);
	}
}

mensajeSpan(['bg'=>'yellow', 'co'=>'#000','text'=>'No puede seguir aquí.','ruta'=>"../panel.php?ap=$Apartado"]);

?>