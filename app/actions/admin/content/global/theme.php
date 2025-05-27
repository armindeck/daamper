<?php if (isset($_GET['tema']) && !empty($_GET['tema']) && isset($_GET['accion'])) {
	$archivo_tema = $Web["directorio"] . 'database/theme/' . SCRIPTS->normalizar($_GET['tema']);
	$_GET['accion'] = SCRIPTS->normalizar(strtolower($_GET['accion']));
	$archivo_tema_confirmar = false;
	if ($_GET['accion'] == 'eliminar') {
		if(file_exists($archivo_tema)) { $archivo_tema_confirmar = unlink($archivo_tema); }
		if(file_exists($Web["directorio"] . 'database/theme/theme.json') && $archivo_tema_confirmar) {
				$archivo_tema_confirmar = unlink($Web["directorio"] . 'database/theme/theme.json'); }
	}
	if (file_exists($archivo_tema)) {
		switch($_GET['accion']) {
			case 'normalizar':
				if(file_exists($Web["directorio"] . 'database/theme/theme.json')) {
					$archivo_tema_confirmar = unlink($Web["directorio"] . 'database/theme/theme.json'); } break;
			case 'utilizar':
				$guardar = ["tema" => "on", "archivo" => SCRIPTS->normalizar($_GET['tema'])];
				$archivo_tema_confirmar = DATA->Save("theme/theme", $guardar); break;
		}
	}
}