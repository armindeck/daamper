<?php
$LISTA_DATOS_POST=[
	'nombre_web','enlace_web','enlace_web_simple','timezone',
	'ano_publicada','language','https_imagen','php','errores','api',
];

foreach (Daamper::$data->Config("default")["api"]["show"] as $key => $value) {
	foreach ($value as $key2 => $value2) {
		$LISTA_DATOS_POST[] = "show-api-$key-$value2";
	}
}

foreach (Daamper::$data->Config("default")["api"]["auto"] as $value) {
	$LISTA_DATOS_POST[] = "show-api-auto-$value";
}

foreach ($LISTA_DATOS_POST as $key => $value) {
	if(!isset($_POST[$value])){ $_POST[$value]=''; }
	$_POST[$value]=Daamper::$scripts->normalizar2($_POST[$value]);
}

$_POST['enlace_web'] = rtrim($_POST['enlace_web'], '/');
$_POST['enlace_web_simple'] = str_replace(['https://','http://'], '', $_POST['enlace_web']);

if(!empty($_POST['https_imagen'])){
	$_POST['https_imagen']=$_POST['enlace_web'].'/';
}

if(!empty($_POST['php'])){
	$_POST['php']='.php';
}

$DATOS_DEFAULT = true;