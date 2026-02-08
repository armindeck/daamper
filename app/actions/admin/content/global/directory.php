<?php
// True or False
$create_file = !empty($_POST['crear_archivo_boton']);
$create_folder = !empty($_POST['crear_carpeta_boton']);
$delete_folder = !empty($_POST['eliminar_carpeta_boton']);
$confirm = !empty($_POST['confirmar']) ? ($_POST['confirmar'] == 'Si' ? true : false) : false;

// String
$get_dir = !empty($_GET['dir']) ? Daamper::$scripts->normalizar2($_GET['dir']) : "";
$dir = !empty($get_dir) ? str_replace(["../", "./"], "", $get_dir) : ""; // Quitar directorio
	$dir .= !empty($dir) && substr($dir, -1) != "/" ? "/" : ""; // Agregar slash al final si no lo tiene
$file = !empty($_POST["archivo"]) ? Daamper::$scripts->normalizar2($_POST['archivo']) : ""; // POST file
$folder = !empty($_POST["carpeta"]) ? Daamper::$scripts->normalizar($_POST['carpeta']) : ""; // POST folder

$parent_directory = $Web["directorio"];
$parent_route = $parent_directory . $dir;

// Routes
$ap_route = "?ap=directory&dir={$parent_route}"; // Ruta en el directorio
$ap_route_editor_create_file = "?ap=editor&dir={$parent_route}&crear=$file"; // Ruta en el editor para crear archivo
$history_route = "database/files/txt/";
$history_route_file = $parent_directory . $history_route . "history.txt";

$folder_route = $parent_directory . $dir . $folder;
$folder_exists = file_exists($folder_route);

$back_route = explode("/", $dir); // Agregar el explode a back route
$count_explode_get_route = count($back_route) - 1; // Contar la ruta
unset($back_route[count($back_route)-1]); // Eliminar la ultima ruta
unset($back_route[count($back_route)-1]); // Eliminar la ultima ruta
$back_route = !empty($count_explode_get_route) ? $parent_directory . (count($back_route) > 0 ? ((implode("/", $back_route)) . "/") : "") : ""; // Back route
$ap_route_delete_folder = "?ap=directory&dir={$back_route}";


// Dirigir al directorio padre
if(empty($get_dir) && !$create_file && !$create_folder && !$delete_folder){
	header("Location: $ap_route");
	exit;
}

// Dirigir al editor para crear un archivo
if($create_file){
	header("Location: $ap_route_editor_create_file");
	exit;
}

// Crear historial si hay alguna acción
if(($create_folder || $delete_folder) && !file_exists($history_route_file)){
	Daamper::$scripts->CrearCarpetas($history_route);
	file_put_contents($history_route_file, "Generado: " . Daamper::$scripts->fecha_hora());
}

if($create_folder){
	if($folder_exists){
		Daamper::$sendAlert->Error(Language(['directory', 'directory-exists'], 'dashboard'), $ap_route);
		exit;
	}
	
	if(mkdir($folder_route, 0777, true)){
		file_put_contents($history_route_file, $folder_route . '/ ~ ' . Daamper::$scripts->fecha_hora() . ' [Folder create] -> ' . $_SESSION['id'] . "\n" . file_get_contents($history_route_file));
		Daamper::$sendAlert->Success(Language(['directory', 'directory-created'], 'dashboard'), $ap_route);
	};
}

if(!empty($delete_folder)){
	if(!$confirm){ Daamper::$sendAlert->Error(Language(['directory', 'confirm-delete'], 'dashboard'), $ap_route); }
	if(!$folder_route){ Daamper::$sendAlert->Error(Language(['directory', 'directory-no-exists'], 'dashboard'), $ap_route); }
	
	$delete_files = 0; $delete_folder = 0;
    foreach (glob($parent_route . '*') as $key => $value) {
		$text_save = Daamper::$scripts->fecha_hora() . " (user: {$_SESSION['id']}) [delete " . (is_dir($value) ? "folder" : "file") . "] -> " . (str_replace(["../", "./"], "", $value)) . (is_dir($value) ? "/" : "") . "\n" . file_get_contents($history_route_file);
		if(is_dir($value)){
			if(rmdir($value . '/')){
				$delete_folder++;
				file_put_contents($history_route_file, $text_save);
			}
		}
		
		if(is_file($value)){
			if(unlink($value)){
				$delete_files++;
				file_put_contents($history_route_file, $text_save);
			}
		}
	}

	if(rmdir($folder_route)){
		$delete_folder++;
		file_put_contents($history_route_file, Daamper::$scripts->fecha_hora() . " (user: {$_SESSION['id']}) [delete folder] -> " . (str_replace(["../", "./"], "", $folder_route)) . "\n" . file_get_contents($history_route_file));
		Daamper::$sendAlert->Success(Language(['directory', 'deleted'], 'dashboard').': <i class="fas fa-folder"></i> '.$delete_folder.' <i class="fas fa-file-code"></i> '.$delete_files, $ap_route_delete_folder);
	} else {
        Daamper::$sendAlert->Success(Language(['directory', 'deleted'], 'dashboard').': <i class="fas fa-folder"></i> '.$delete_folder.' <i class="fas fa-file-code"></i> '.$delete_files, $ap_route);
    }
}