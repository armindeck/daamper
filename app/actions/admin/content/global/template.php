<?php function PlantillaAccion() { global $Web;
	if(isset($_GET['accion']) && in_array(strtolower($_GET['accion']), ['restaurar'])) {
		$_GET['accion'] = SCRIPTS->normalizar(strtolower($_GET['accion']));
		if (in_array($_GET['accion'], ['restaurar'])) {
			#$eliminar = ['web-template.php', 'web-template-scripts.php'];
			$eliminar = ['template.json', 'scr-template.json'];
			#if(file_exists(__DIR__.'/'.$eliminar[0])) { $mensaje_confirmar = unlink(__DIR__.'/'.$eliminar[0]); }
			#if(file_exists(__DIR__.'/'.$eliminar[1])) { unlink(__DIR__.'/'.$eliminar[1]); }
			if(file_exists($Web["directorio"].'database/template/'.$eliminar[0])) { $mensaje_confirmar = unlink($Web["directorio"].'database/template/'.$eliminar[0]); }
			if(file_exists($Web["directorio"].'database/template/'.$eliminar[1])) { unlink($Web["directorio"].'database/template/'.$eliminar[1]); }
			unset($Web['template']);
		}
	}
	if (isset($_GET['plantilla']) && !empty($_GET['plantilla'])) {
		$archivo_plantilla = SCRIPTS->normalizar($_GET['plantilla']);
		#$ruta_plantilla = __DIR__."/plantillas/{$archivo_plantilla}";
		#$ruta_plantilla_scripts = __DIR__."/plantillas/scr-{$archivo_plantilla}";
		$ruta_plantilla = $Web["directorio"]."database/template/{$archivo_plantilla}";
		$ruta_plantilla_scripts = $Web["directorio"]."database/template/scr-{$archivo_plantilla}";
		if (file_exists($ruta_plantilla)) {
			if(isset($_GET['accion']) && in_array(strtolower($_GET['accion']), ['mostrar', 'eliminar'])) {
				$_GET['accion'] = SCRIPTS->normalizar(strtolower($_GET['accion']));
				
				if (in_array($_GET['accion'], ['mostrar'])) {
					#$Web['template'] = require $ruta_plantilla;
					#$Web['template']['scr'] = require $ruta_plantilla_scripts;
					$Web['template'] = DATA->Read("template/" . basename($ruta_plantilla));
					$Web['template']['scr'] = DATA->Read("template/" . basename($ruta_plantilla_scripts));
				}
				if (in_array($_GET['accion'], ['eliminar'])) {
					if(file_exists($ruta_plantilla)) { $mensaje_confirmar = unlink($ruta_plantilla); }
					if(file_exists($ruta_plantilla_scripts)) { unlink($ruta_plantilla_scripts); }
				}
			}
		}
	}
} PlantillaAccion(); ?>