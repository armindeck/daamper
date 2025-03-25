<?php
$Panel['ap_directorio_dir'] = $Web['directorio'];
if(!isset($_GET['dir'])){
	if (!isset($_POST['crear_archivo_boton']) && !isset($_POST['crear_carpeta_boton']) && !isset($_POST['eliminar_carpeta_boton'])) {
		header("Location: ?ap=directorio&dir={$Web['directorio']}");
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
if(!file_exists(__DIR__.'/historial.txt')){
	file_put_contents(__DIR__.'/historial.txt','Generado: '. SCRIPTS->fecha_hora());
}

if(isset($_POST['crear_carpeta_boton']) && !empty($_POST['crear_carpeta_boton'])){
	if(!file_exists($Panel['ap_directorio_dir'].SCRIPTS->normalizar($_POST['carpeta']))){
		if(mkdir($Panel['ap_directorio_dir'].SCRIPTS->normalizar($_POST['carpeta']), 0777, true)){
			file_put_contents(__DIR__.'/historial.txt', $Panel['ap_directorio_dir'].SCRIPTS->normalizar($_POST['carpeta']).'/ ~ ' . SCRIPTS->fecha_hora() . ' [Creado] -> '. $_SESSION['id']."\n".file_get_contents(__DIR__.'/historial.txt'));
		};
		mensajeSpan(['bg'=>'green','text'=>Language(['directorio', 'directory-created'], 'dashboard'),'ruta'=>"?ap=directorio&dir={$Panel['ap_directorio_dir']}"]);
	} else {
		mensajeSpan(['bg'=>'red','text'=>Language(['directorio', 'directory-exists'], 'dashboard'),'ruta'=>"?ap=directorio&dir={$Panel['ap_directorio_dir']}"]);
	}
}

if(isset($_POST['eliminar_carpeta_boton']) && !empty($_POST['eliminar_carpeta_boton'])){
	if($_POST['confirmar'] != 'Si'){
		mensajeSpan(['bg'=>'red','text'=>Language(['directorio', 'confirm-delete'], 'dashboard'),'ruta'=>"?ap=directorio&dir={$Panel['ap_directorio_dir']}"]);
	}
	if(file_exists($Panel['ap_directorio_dir'].SCRIPTS->normalizar($_POST['carpeta']))){
		$eliminados_archivos = 0; $eliminados_carpeta = 0;
		foreach (glob($Panel['ap_directorio_dir'].'*') as $key => $value) {
			if(is_dir($value)){
				if(rmdir($value.'/')){
					$eliminados_carpeta++;
					file_put_contents(__DIR__.'/historial.txt', $Panel['ap_directorio_dir'].$value.'/ ~ ' . SCRIPTS->fecha_hora() . ' [Eliminado] -> '. $_SESSION['id']."\n".file_get_contents(__DIR__.'/historial.txt'));
				}
			}
			if(is_file($value)){
				if(unlink($value)){
					$eliminados_archivos++;
					file_put_contents(__DIR__.'/historial.txt', $Panel['ap_directorio_dir'].$value.' ~ ' . SCRIPTS->fecha_hora() . ' [Eliminado] -> '. $_SESSION['id']."\n".file_get_contents(__DIR__.'/historial.txt'));
				}
			}
		}
		if(rmdir($Panel['ap_directorio_dir'].SCRIPTS->normalizar($_POST['carpeta']))){
			$eliminados_carpeta++;
			file_put_contents(__DIR__.'/historial.txt', $Panel['ap_directorio_dir'].$value.'/ ~ ' . SCRIPTS->fecha_hora() . ' [Eliminado] -> '. $_SESSION['id']."\n".file_get_contents(__DIR__.'/historial.txt'));
		}
		mensajeSpan(['bg'=>'green','text'=>Language(['directorio', 'deleted'], 'dashboard').': <i class="fas fa-folder"></i> '.$eliminados_carpeta.' <i class="fas fa-file-code"></i> '.$eliminados_archivos,'ruta'=>"?ap=directorio&dir={$Panel['ap_directorio_dir']}"]);
	} else {
		mensajeSpan(['bg'=>'red','text'=>Language(['directorio', 'directory-no-exists'], 'dashboard'),'ruta'=>"?ap=directorio&dir={$Panel['ap_directorio_dir']}"]);
	}
}

?>