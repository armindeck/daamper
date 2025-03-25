<?php function PlantillaAccion() {
	if(isset($_GET['accion']) && in_array(strtolower($_GET['accion']), ['restaurar'])) {
		$_GET['accion'] = SCRIPTS->normalizar(strtolower($_GET['accion']));
		if (in_array($_GET['accion'], ['restaurar'])) { global $Web;
			$eliminar = ['web-plantilla.php', 'web-plantilla-scripts.php'];
			if(file_exists(__DIR__.'/'.$eliminar[0])) { $mensaje_confirmar = unlink(__DIR__.'/'.$eliminar[0]); }
			if(file_exists(__DIR__.'/'.$eliminar[1])) { unlink(__DIR__.'/'.$eliminar[1]); }
			unset($Web['plantilla']);
		}
	}
	if (isset($_GET['plantilla']) && !empty($_GET['plantilla'])) {
		$archivo_plantilla = SCRIPTS->normalizar($_GET['plantilla']);
		$ruta_plantilla = __DIR__."/plantillas/{$archivo_plantilla}";
		$ruta_plantilla_scripts = __DIR__."/plantillas/scr-{$archivo_plantilla}";
		if (file_exists($ruta_plantilla)) {
			if(isset($_GET['accion']) && in_array(strtolower($_GET['accion']), ['mostrar', 'eliminar'])) {
				$_GET['accion'] = SCRIPTS->normalizar(strtolower($_GET['accion']));
				
				if (in_array($_GET['accion'], ['mostrar'])) { global $Web;
					$Web['plantilla'] = require $ruta_plantilla;
					$Web['plantilla']['scr'] = require $ruta_plantilla_scripts;
				}
				if (in_array($_GET['accion'], ['eliminar'])) {
					if(file_exists($ruta_plantilla)) { $mensaje_confirmar = unlink($ruta_plantilla); }
					if(file_exists($ruta_plantilla_scripts)) { unlink($ruta_plantilla_scripts); }
				}
			}
		}
	}
} PlantillaAccion(); ?>