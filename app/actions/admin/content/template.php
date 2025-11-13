<?php
/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  template.php                                                          */
/**************************************************************************/
/*                        This file is part of:                           */
/*                              daamper                                   */
/*                 https://github.com/armindeck/daamper                   */
/**************************************************************************/
/* Copyright (c) 2025 DBHS / daamper                                      */
/*                                                                        */
/* Se concede permiso, de forma gratuita, a cualquier persona para usar,  */
/* modificar y ejecutar el código fuente de este software, incluyendo su  */
/* uso en proyectos comerciales (como monetización por publicidad o       */
/* donaciones).                                                           */
/*                                                                        */
/* Restricciones estrictas:                                               */
/* - No está permitido vender, sublicenciar o distribuir el código        */
/*   fuente —total o parcialmente— con fines de lucro.                    */
/* - No está permitido convertir el código en privativo ni eliminar       */
/*   esta licencia.                                                       */
/* - No está permitido reclamar la autoría del código original.           */
/*                                                                        */
/* Uso permitido:                                                         */
/* - Se permite modificar y usar el código con fines personales,          */
/*   educativos y/o comerciales, siempre que no se venda.                 */
/* - Se permite usar este software como base para otros proyectos,        */
/*   siempre que esta licencia se mantenga.                               */
/*                                                                        */
/* El autor (DBHS / daamper) se reserva el derecho de modificar esta      */
/* licencia en futuras versiones del software.                            */
/*                                                                        */
/* EL SOFTWARE SE ENTREGA "TAL CUAL", SIN GARANTÍAS DE NINGÚN TIPO,       */
/* EXPRESAS O IMPLÍCITAS, INCLUYENDO, SIN LIMITACIÓN, GARANTÍAS DE        */
/* COMERCIABILIDAD, IDONEIDAD PARA UN PROPÓSITO PARTICULAR Y NO           */
/* INFRACCIÓN. EN NINGÚN CASO LOS AUTORES SERÁN RESPONSABLES POR          */
/* RECLAMACIONES, DAÑOS U OTRAS RESPONSABILIDADES, YA SEA EN UNA ACCIÓN   */
/* CONTRACTUAL, EXTRACONTRACTUAL O DE OTRO TIPO, DERIVADAS DE O EN        */
/* CONEXIÓN CON EL SOFTWARE, SU USO O OTRO TIPO DE MANEJO.                */
/**************************************************************************/

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
$lista_enteros = []; $lista_post_oficial = ['procesa_plantilla', 'procesa_template', 'cargar_scripts', 'archivo_plantilla', 'cantidad_contenedores'];

for ($i = 1; $i <= $cantidad_contenedores; $i++){
	$lista_contenedores[$i]=[
		'mostrar_contenedor_'.$i,
		'tipo_contenedor_'.$i,
		'cantidad_elementos_contenedor_'.$i,
		'nombre_contenedor_'.$i,
		'div_abrir_contenedor_'.$i,
		'div_cerrar_contenedor_'.$i,
		"mostrar_campos_para_los_elementos_contenedor_{$i}"
	];

	foreach ($lista_contenedores[$i] as $key => $value) {
		$lista_post_oficial[] = $value;
		if($value == 'mostrar_contenedor_'.$i){
			$lista_enteros[$i]='mostrar_contenedor_'.$i;
		}
		if($value == "mostrar_campos_para_los_elementos_contenedor_{$i}"){
			$_POST[$value] = implode(",", $_POST["mostrar_campos_para_los_elementos_contenedor_{$i}"] ?? []);
		}
		$pos[$value] = isset($_POST[$value]) ? Daamper::$scripts->quitarComilla($_POST[$value]) : '';
	}

	for ($ii=1; $ii<=$pos['cantidad_elementos_contenedor_'.$i]; $ii++){
		$lista_contenedores_elementos[$i]=[
			'mostrar_elemento_'.$ii.'_contenedor_'.$i,
			"nombre_elemento_{$ii}_contenedor_{$i}",
			'titulo_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			'contenido_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			'div_abrir_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			'div_cerrar_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			'ocultar_etiquetas_contenedor_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			'estilos_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			'comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i,
			"mostrar_campos_para_el_elemento_{$ii}_contenedor_{$i}"
		];
		foreach ($lista_contenedores_elementos[$i] as $key => $value) {
			$lista_post_oficial[] = $value;
			if($value == "mostrar_campos_para_el_elemento_{$ii}_contenedor_{$i}"){
				$vv = implode(",", $_POST["mostrar_campos_para_el_elemento_{$ii}_contenedor_{$i}"] ?? []);
				if($vv != $pos["mostrar_campos_para_los_elementos_contenedor_{$i}"]){
					$_POST[$value] = $vv;
					$pos[$value] = isset($_POST[$value]) ? Daamper::$scripts->quitarComilla($_POST[$value]) : '';
				}
			} else {
				$pos[$value] = isset($_POST[$value]) ? Daamper::$scripts->quitarComilla($_POST[$value]) : '';
			}
		}
	}	

}

$post = [];
foreach ($pos as $key => $value) {
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