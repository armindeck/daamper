<?php
$cantidad_contenedores = Daamper::$scripts->normalizar($_POST['cantidad_contenedores']);
$cargar_scripts = Daamper::$scripts->normalizar($_POST['cargar_scripts']);
$archivo_plantilla = isset($_POST['archivo_plantilla']) && !empty($_POST['archivo_plantilla']) ? Daamper::$scripts->archivoAceptado(str_replace(['.php', '.json'], '', $_POST['archivo_plantilla']) . '.json') : false;

$_POST['cargar_scripts_errores'] = '';

Daamper::$scripts->CrearCarpetas("database/template/");

$template_scripts = __DIR__."/src/template.php";

if(!file_exists($template_scripts)){
	$_POST['cargar_scripts_errores'] = 'on';
}

$pos['archivo_plantilla'] = $archivo_plantilla;
$pos['cantidad_contenedores'] = $cantidad_contenedores;
$pos['cargar_scripts'] = $cargar_scripts;
$pos['cargar_scripts_errores'] = $_POST['cargar_scripts_errores'];

$lista_contenedores = []; $lista_contenedores_elementos = [];
$lista_enteros = [];

for ($i = 1; $i <= $cantidad_contenedores; $i++){
	$lista_contenedores[$i]=[
		'mostrar_contenedor_'.$i,
		'tipo_contenedor_'.$i,
		'cantidad_elementos_contenedor_'.$i,
		'nombre_contenedor_'.$i,
		'div_abrir_contenedor_'.$i,
		'div_cerrar_contenedor_'.$i
	];

	foreach ($lista_contenedores[$i] as $key => $value) {
		if($value == 'mostrar_contenedor_'.$i){
			$lista_enteros[$i]='mostrar_contenedor_'.$i;
		}
		$pos[$value] = isset($_POST[$value]) ? Daamper::$scripts->quitarComilla($_POST[$value]) : '';
	}

	for ($ii=1; $ii<=$pos['cantidad_elementos_contenedor_'.$i]; $ii++){
		$lista_contenedores_elementos[$i]=[
			'mostrar_elemento_'.$ii.'_contenedor_'.$i,
			'titulo_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			'contenido_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			'div_abrir_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			'div_cerrar_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			'ocultar_etiquetas_contenedor_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			'estilos_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			'comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i
		];
		foreach ($lista_contenedores_elementos[$i] as $key => $value) {
			$pos[$value] = isset($_POST[$value]) ? Daamper::$scripts->quitarComilla($_POST[$value]) : '';
		}
	}	

}

$post = [];
$lista_post_oficial = ['procesa_plantilla'];
foreach ($pos as $key => $value) {
	$lista_post_oficial[] = $key;
	if (!empty($value)){ $post[$key] = $value; }
}

# CONVERTIR PLANTILLAS Y TRANSFERIRLAS A DATABASE/PLANTILLA/
if(file_exists("../app/plantilla/plantillas/")){
	$files_conver = glob(__DIR__."/plantillas/*", GLOB_BRACE);
	foreach ($files_conver as $key => $value) {
		Daamper::$data->Save("template/" . basename($value), require $value);
	}
}
Daamper::$data->Save("template/template", $post);

if ($archivo_plantilla) {
	Daamper::$data->Save("template/$archivo_plantilla", $post);
}

$post = null; $pos = null;

if(!empty($cargar_scripts) && file_exists($template_scripts)){
	require $template_scripts;
}

Daamper::$sendAlert->Success(Language('data-save'), $Web['directorio']."admin/admin.php?ap=template");