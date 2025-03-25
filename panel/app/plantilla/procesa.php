<?php
$cantidad_contenedores = SCRIPTS->normalizar($_POST['cantidad_contenedores']);
$cargar_scripts = SCRIPTS->normalizar($_POST['cargar_scripts']);
$archivo_plantilla = isset($_POST['archivo_plantilla']) && !empty($_POST['archivo_plantilla']) ? SCRIPTS->archivoAceptado(str_replace('.php', '', $_POST['archivo_plantilla']) . '.php') : false;

$_POST['cargar_scripts_errores'] = '';

if(!file_exists(__DIR__.'/plantillas/')){ if(mkdir(__DIR__.'/plantillas/', 0777, true)); }

if(!file_exists(__DIR__.'/procesa_scripts.php')){
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
		$pos[$value] = isset($_POST[$value]) ? SCRIPTS->quitarComilla($_POST[$value]) : '';
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
			$pos[$value] = isset($_POST[$value]) ? SCRIPTS->quitarComilla($_POST[$value]) : '';
		}
	}	

}

$guardar = "<?php #". SCRIPTS->xv('plantilla', null, true);
$guardar .= "\nreturn [";

$lista_post_oficial = ['procesa_plantilla'];
foreach ($pos as $key => $value) {
	$lista_post_oficial[] = $key;
	$guardar .= !empty($value) ? "'$key' => '$value',\n" : '';
}

$guardar .= "];\n?>";

file_put_contents(__DIR__.'/web-plantilla.php', $guardar);

if ($archivo_plantilla) {
	file_put_contents(__DIR__."/plantillas/{$pos['archivo_plantilla']}", $guardar);
}

$pos = null; $guardar = '';

if(!empty($cargar_scripts) && file_exists(__DIR__.'/procesa_scripts.php')){
	require __DIR__ . '/procesa_scripts.php';
}

mensajeSpan(['bg' => 'green','ruta' => $Web['directorio']."panel/panel.php?ap=plantilla", 'text' => Language('data-save')]);