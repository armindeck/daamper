<?php
$Panel['ap_directorio_dir'] = $Web['directorio'];
if(!isset($_GET['dir'])){
	if (!isset($_POST['crear_archivo_boton']) && !isset($_POST['crear_carpeta_boton']) && !isset($_POST['eliminar_carpeta_boton'])) {
		header("Location: ?ap=directory&dir={$Web['directorio']}");
	}
} else {
	$Panel['ap_directorio_dir']=SCRIPTS->normalizar2($_GET['dir']);
}
?>
<?php
if(isset($_POST['crear_archivo_boton']) && !empty($_POST['crear_archivo_boton'])){
	header("Location: ?ap=editor&dir={$Panel['ap_directorio_dir']}&crear=".SCRIPTS->normalizar2($_POST['archivo']));
	exit;
}
$dbroutedirectoryhistory = $Web["directorio"] . "database/files/txt/history/directory/directory.txt";
SCRIPTS->CrearCarpetas("database/files/txt/history/directory/");
if(!file_exists($dbroutedirectoryhistory)){
	file_put_contents($dbroutedirectoryhistory,'Generado: '. SCRIPTS->fecha_hora());
}

if(isset($_POST['crear_carpeta_boton']) && !empty($_POST['crear_carpeta_boton'])){
	if(!file_exists($Panel['ap_directorio_dir'].SCRIPTS->normalizar($_POST['carpeta']))){
		if(mkdir($Panel['ap_directorio_dir'].SCRIPTS->normalizar($_POST['carpeta']), 0777, true)){
			file_put_contents($dbroutedirectoryhistory, $Panel['ap_directorio_dir'].SCRIPTS->normalizar($_POST['carpeta']).'/ ~ ' . SCRIPTS->fecha_hora() . ' [Creado] -> '. $_SESSION['id']."\n".file_get_contents($dbroutedirectoryhistory));
		};
		sendAlert->Success(Language(['directory', 'directory-created'], 'dashboard'), "?ap=directory&dir={$Panel['ap_directorio_dir']}");
	} else {
		sendAlert->Error(Language(['directory', 'directory-exists'], 'dashboard'), "?ap=directory&dir={$Panel['ap_directorio_dir']}");
	}
}

if(isset($_POST['eliminar_carpeta_boton']) && !empty($_POST['eliminar_carpeta_boton'])){
	if($_POST['confirmar'] != 'Si'){
		sendAlert->Error(Language(['directory', 'confirm-delete'], 'dashboard'), "?ap=directory&dir={$Panel['ap_directorio_dir']}");
	}
	if(file_exists($Panel['ap_directorio_dir'].SCRIPTS->normalizar($_POST['carpeta']))){
		$eliminados_archivos = 0; $eliminados_carpeta = 0;
		foreach (glob($Panel['ap_directorio_dir'].'*') as $key => $value) {
			if(is_dir($value)){
				if(rmdir($value.'/')){
					$eliminados_carpeta++;
					file_put_contents($dbroutedirectoryhistory, $Panel['ap_directorio_dir'].$value.'/ ~ ' . SCRIPTS->fecha_hora() . ' [Eliminado] -> '. $_SESSION['id']."\n".file_get_contents($dbroutedirectoryhistory));
				}
			}
			if(is_file($value)){
				if(unlink($value)){
					$eliminados_archivos++;
					file_put_contents($dbroutedirectoryhistory, $Panel['ap_directorio_dir'].$value.' ~ ' . SCRIPTS->fecha_hora() . ' [Eliminado] -> '. $_SESSION['id']."\n".file_get_contents($dbroutedirectoryhistory));
				}
			}
		}
		if(rmdir($Panel['ap_directorio_dir'].SCRIPTS->normalizar($_POST['carpeta']))){
			$eliminados_carpeta++;
			file_put_contents($dbroutedirectoryhistory, $Panel['ap_directorio_dir'].$value.'/ ~ ' . SCRIPTS->fecha_hora() . ' [Eliminado] -> '. $_SESSION['id']."\n".file_get_contents($dbroutedirectoryhistory));
		}
		sendAlert->Success(Language(['directory', 'deleted'], 'dashboard').': <i class="fas fa-folder"></i> '.$eliminados_carpeta.' <i class="fas fa-file-code"></i> '.$eliminados_archivos, "?ap=directory&dir={$Panel['ap_directorio_dir']}");
	} else {
		sendAlert->Error(Language(['directory', 'directory-no-exists'], 'dashboard'), "?ap=directory&dir={$Panel['ap_directorio_dir']}");
	}
}