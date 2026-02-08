<?php
/*

- Carpeta existe
	- Archivo existe
		- Editar
		- Eliminar
	- Crear archivo

*/

$directory = $Web["directorio"];

/* ---------- GET ---------- */
$get_dir = Daamper::$scripts->normalizar2($_GET['dir'] ?? "");
$get_crear = Daamper::$scripts->normalizar2($_GET['crear'] ?? "");
$get_permise = Daamper::$scripts->normalizar2($_GET['permise'] ?? false);

$dir = !empty($get_dir) ? str_replace(["../", "./"], "", $get_dir) : "";
$dir .= !empty($get_crear) && !empty($dir) && substr($dir, -1) != "/" ? "/" : "";

$parent_directory = $directory;
$parent_route = $parent_directory . $dir; // base path or full file path when editing

$folder_route = empty($get_crear) ? dirname($parent_route) : $parent_route;
$folder_exists = file_exists($folder_route);

/* ---------- POST ---------- */
$create_or_edit_file = !empty($_POST['submit_create_or_edit_file']);
$delete_file = !empty($_POST['submit_delete_file']);
$confirm_create_or_edit_file = !empty($_POST['confirm_create_or_edit_file']) ? ($_POST['confirm_create_or_edit_file'] == 1) : false;
$confirm_delete_file = !empty($_POST['confirm_delete_file']) ? ($_POST['confirm_delete_file'] == 1) : false;

$file_name = Daamper::$scripts->normalizar2($_POST['file_name'] ?? "");
$file_content = $_POST['file_content'] ?? "";

// Determine target file path: when creating use parent_route + crear, otherwise parent_route is the file path
$target_file = empty($get_crear) ? $parent_route : $parent_route . $get_crear;
$file_exists = file_exists($target_file);

// Load file content when not provided via POST
if(empty($file_content) && $file_exists){
	$file_content = file_get_contents($target_file) ?: "";
}

// Routes
$ap_route = "?ap=directory&dir={$parent_route}";
$history_route = "database/files/txt/";

// Redirect to directory when no dir and no actions
if(empty($get_dir) && !$create_or_edit_file && !$delete_file){
	header("Location: $ap_route");
	exit;
}

if(empty($get_dir)){
	Daamper::$sendAlert->Error(Language(['editor', 'file-required'], 'dashboard'), "?ap=directory&dir={$directory}");
}

if(empty($get_crear)){
	if(is_dir($get_dir)){
		Daamper::$sendAlert->Error(Language(['editor', 'only-edit-files'], 'dashboard'), "?ap=directory&dir={$get_dir}");
	}
	if(!$file_exists && !$get_permise){
		Daamper::$sendAlert->Error(Language('file-no-exists', 'global', ['value'=> '<strong>'.basename($target_file).'</strong>']), "?ap=directory&dir={$parent_route}");
	}
} else {
	if(!is_dir($get_dir) || is_dir($target_file)){
		Daamper::$sendAlert->Error(Language(['editor', 'only-edit-files'], 'dashboard'), "?ap=directory&dir={$parent_route}");
	}
}

// Permission checks (preserve original intent)
$parts = explode('/', $target_file);
if(count($parts) > 2){
	$prefix = $parts[0].'/'.$parts[1].'/'.$parts[2];
	if($prefix === '../admin/app' && !$get_permise && ($_SESSION['rol'] ?? '') !== 'CEO Founder'){
		Daamper::$sendAlert->Warning(Language(['editor', 'file-no-permission'], 'dashboard'), "?ap=directory&dir=".dirname($parent_route).'/');
	}
}

// History folder
$routehistoritxt = "database/files/txt/history/editor/";
Daamper::$scripts->CrearCarpetas($routehistoritxt);

// Save changes
if($create_or_edit_file){
	if(empty($confirm_create_or_edit_file)){
		Daamper::$sendAlert->Error(Language(['editor', 'confirm-create-or-edit-file'], 'dashboard'), "?ap=editor&dir={$target_file}");
	}

	file_put_contents($target_file, $file_content);
	$history_file = $Web["directorio"].$routehistoritxt.Daamper::$scripts->eslasToGuion(Daamper::$scripts->quitarPuntoEslas($target_file.'.txt'));
	if(!file_exists($history_file)){
		file_put_contents($history_file, 'Generado: ' . Daamper::$scripts->fecha_hora() . ' -> ' . ($_SESSION['id'] ?? ''));
	}
	file_put_contents($history_file, Daamper::$scripts->fecha_hora() ." ~ Modificado -> ".($_SESSION['id'] ?? "")."\n".file_get_contents($history_file));

	Daamper::$sendAlert->Success(Language('file-save', 'global', ['value' => '<strong>'.basename($target_file).'</strong>']), "?ap=editor&dir={$target_file}");
}

// Delete file
if($delete_file){
	if(empty($confirm_delete_file)){
		Daamper::$sendAlert->Error(Language(['editor', 'confirm-delete'], 'dashboard'), "?ap=editor&dir={$target_file}");
	}

	if(file_exists($target_file)){
		unlink($target_file);
		$history_file = $Web["directorio"].$routehistoritxt.Daamper::$scripts->eslasToGuion(Daamper::$scripts->quitarPuntoEslas($target_file.'.txt'));
		file_put_contents($history_file, Daamper::$scripts->fecha_hora() ." ~ Eliminado -> ".($_SESSION['id'] ?? "")."\n".file_get_contents($history_file));
		$dir_eliminado = (dirname($target_file) === '..') ? '../' : dirname($target_file).'/';
		Daamper::$sendAlert->Success(Language('file-delete', 'global', ['value' => '<strong>'.basename($target_file).'</strong>']), "?ap=directory&dir=".$dir_eliminado);
	} else {
		Daamper::$sendAlert->Error(Language(['directory', 'directory-no-exists'], 'dashboard'), "?ap=editor&dir={$target_file}");
	}
}
