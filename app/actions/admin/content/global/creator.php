<?php

/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  creator.php                                                           */
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

$name = [
	"refresh" => "refrescar",
	"show" => "mostrar",
	"publish" => "publicacion",
	"draft" => "borrador",
	"creator" => "creador",
	"type" => "tipo",
	"file" => "archivo",
];

$route_posts = "database/post/";
$route_drafts = "database/draft/";
$creator_routes = "app/views/admin/creators/";

$submit_refresh = isset($_POST[$name["refresh"]]) && !empty($_POST[$name["refresh"]]);
$submit_show = isset($_POST[$name["show"]]) && !empty($_POST[$name["show"]]);
$submit_publish = isset($_POST[$name["publish"]]) && !empty($_POST[$name["publish"]]);
$submit_draft = isset($_POST[$name["draft"]]) && !empty($_POST[$name["draft"]]);
$submit_publish_or_draft = $submit_publish ? $name["publish"] : ($submit_draft ? $name["draft"] : '');

$submit_get_creator = isset($_GET[$name['creator']]) && !empty($_GET[$name['creator']]);
$submit_get_type = isset($_GET[$name['type']]) && !empty($_GET[$name['type']]);
$submit_get_file = isset($_GET[$name['file']]) && !empty($_GET[$name['file']]);

$get_creator = $submit_get_creator ? Daamper::$scripts->normalizar2($_GET[$name['creator']]) : '';
$get_type = $submit_get_type ? Daamper::$scripts->normalizar2($_GET[$name['type']]) : '';
$get_file = $submit_get_file ? Daamper::$scripts->normalizar2($_GET[$name['file']]) : '';



$route_get_type = $get_type == 'publicacion' ? $route_posts : ($get_type == 'borrador' ? $route_drafts : '');
$route_get_type_file = $route_get_type . $get_file;
$route_get_type_file_path = RAIZ . $route_get_type . $get_file;
$route_get_type_file_path_exists = file_exists($route_get_type_file_path);

$submit_get_show_creator = $submit_get_creator && $submit_get_type && $submit_get_file;
$submit_get_type_confirm = in_array($get_type, ['publicacion', 'borrador']);

$data_list_required = [$name['creator'], 'db_ruta'];

$creator_routes_path = RAIZ . $creator_routes;
$creator_routes_path_files = glob($creator_routes_path . "*-view.php");
$creator_route_file = "{$creator_routes}{$get_creator}-view.php";
$creator_route_file_path = RAIZ . $creator_route_file;
$creator_route_file_path_exists = file_exists($creator_route_file_path);

$Creator = [
	'get_tipo' => $get_type,
	'get_archivo' => $get_file,
	'get_creador' => $get_creator,
	'submit_get_creator' => $submit_get_creator,
	'submit_get_type' => $submit_get_type,
	'submit_get_file' => $submit_get_file,
	'get_creator' => $get_creator,
	'get_type' => $get_type,
	'get_file' => $get_file,
	'route_posts' => $route_posts,
	'route_drafts' => $route_drafts,
	'route_get_type' => $route_get_type,
	'route_get_type_file' => $route_get_type_file,
	'route_get_type_file_path' => $route_get_type_file_path,
	'route_get_type_file_path_exists' => $route_get_type_file_path_exists,
	'submit_get_show_creator' => $submit_get_show_creator,
	'submit_get_type_confirm' => $submit_get_type_confirm,
	'creator_routes' => $creator_routes,
	'creator_routes_path' => $creator_routes_path,
	'creator_routes_path_files' => $creator_routes_path_files,
	'creator_route_file' => $creator_route_file,
	'creator_route_file_path' => $creator_route_file_path,
	'creator_route_file_path_exists' => $creator_route_file_path_exists,
];

if ($submit_refresh) {
	$ruta_get = '?ap=creator';
	$ruta_get .= $submit_get_creator ? '&creador=' . $get_creator : '';
	$ruta_get .= $submit_get_type ? '&tipo=' . $get_type : '';
	$ruta_get .= $submit_get_file ? '&archivo=' . $get_file : '';
	Daamper::$sendAlert->Refresh(Language('refreshed'), $ruta_get, $_POST);
}

if ($submit_show) {
	$_SESSION['tmpForm'] = $_POST;
	$_SESSION['instance_destroy'] = true;
	header("Location: process/creator.php");
	exit;
}

if ($submit_publish || $submit_draft) {
	header("Location: ?ap=creator&creador=normal&tipo={$submit_publish_or_draft}&archivo={$_POST[$submit_publish_or_draft]}"); /// ?????? deprecated ????
	exit;
}

if ($submit_get_show_creator && $submit_get_type_confirm && !$route_get_type_file_path_exists) {
	Daamper::$sendAlert->Error(Language('file-no-exists', 'global', ['value' => '<strong>' . $get_file . '</strong>']), "?ap=creator");
	exit;
}

if ($submit_get_show_creator) {
	if ($submit_get_type_confirm) {
		$read = Daamper::$data->Read($route_get_type_file);

		$ACR = $read["ACR"];
		$AC = $read["AC"];
		
		if (!isset($ACR[$name['creator']])) {
			Daamper::$sendAlert->Error(Language('file-exists-no-data-or-incomplete', 'alert'), "?ap=creator");
		}

		foreach ($data_list_required as $key => $value) {
			if (!isset($ACR[$value])) {
				Daamper::$sendAlert->Error(Language('file-no-data-creator-or-ruta', 'alert'), "?ap=creator");
			}
		}

		if ($get_creator != $ACR[$name['creator']]) {
			header("Location: ?ap=creator&creador={$ACR[$name['creator']]}&tipo={$get_type}&archivo={$get_file}");
			exit;
		}

		if (!isset($_SESSION['tmpForm'])) {
			$tmp = [];
			foreach ($AC as $key => $value) {
				$tmp[$key] = $value;
			}
			foreach ($ACR as $key => $value) {
				if ($key != 'db_ruta' || $key != 'id_publicador') {
					$tmp[$key] = $value;
				}
			}
			$_SESSION['tmpForm'] = $tmp;
		}
	}
	unset($tmp);
	unset($ACR);
	unset($AC);
}

if (isset($_GET['actualizar-entradas']) && isset($_GET['cantidad-entradas']) && !empty($_GET['cantidad-entradas'])) {
	$post = [];
	for ($j = 0; $j < Daamper::$scripts->normalizar2($_GET['cantidad-entradas']); $j++) {
		$post[] = [
			'entrada' => strtolower($_GET["entrada-$j"] ?? ''),
			'poster' => $_GET["entrada-poster-$j"] ?? '',
			'titulo' => $_GET["entrada-titulo-$j"] ?? '',
			'titulo-alternativo' => $_GET["entrada-titulo-alternativo-$j"] ?? ''
		];
	}

	$confirmar = Daamper::$data->Save("creator/list-of-entries", $post);
	if (!$confirmar) {
		Daamper::$sendAlert->Error(Language('data-no-save'), "admin.php?ap=creator");
	}
	Daamper::$sendAlert->Success(Language('data-save'), "admin.php?ap=creator");
}
