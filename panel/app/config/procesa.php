<?php
$LISTA_DATOS_POST=[
	'nombre_web','enlace_web','enlace_web_simple','timezone',
	'ano_publicada','language','https_imagen','php','errores'
];

foreach ($LISTA_DATOS_POST as $key => $value) {
	if(!isset($_POST[$value])){ $_POST[$value]=''; }
	$_POST[$value]=SCRIPTS->normalizar2($_POST[$value]);
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
?>