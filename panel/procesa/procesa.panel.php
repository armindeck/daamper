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
	mensajeSpan(['bg'=>'yellow', 'co'=>'#000','text'=>Language('no-access-file'),'ruta'=>"../panel.php"]);
}

if(file_exists('../app/'.$Apartado.'/procesa.php')){
	require '../app/'.$Apartado.'/procesa.php';
} else {
	mensajeSpan(['bg'=>'red','text'=>Language('file-not-exist-section'),'ruta'=>"../panel.php?ap=$Apartado"]);
}

if(isset($DATOS_DEFAULT) && $DATOS_DEFAULT){
	if(!isset($LISTA_DATOS_POST)){
		mensajeSpan(['bg'=>'red','text'=>Language('data-list-not-exist'),'ruta'=>"../panel.php?ap=$Apartado"]);
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
	if ($Apartado == 'config') {
		if (!isset($post['language']) || empty($post['language'])){
			$post['language'] = 'es';
		}
		$post['languaje'] = $post['language'];
		print_r($post);
		file_put_contents('../../database/config/config.json', json_encode($post));
	}
	if($confirmar){
		mensajeSpan(['bg'=>'green','text'=>Language('data-save'),'ruta'=>"../panel.php?ap=$Apartado"]);
	} else {
		mensajeSpan(['bg'=>'red','text'=>Language('data-no-save'),'ruta'=>"../panel.php?ap=$Apartado"]);
	}
}

mensajeSpan(['bg'=>'yellow', 'co'=>'#000','text'=>Language('cannot-stay-here'),'ruta'=>"../panel.php?ap=$Apartado"]);

?>