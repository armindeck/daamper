<?php if (isset($_GET['tema']) && !empty($_GET['tema']) && isset($_GET['accion'])) {
	$archivo_tema = __DIR__ . '/temas/' . SCRIPTS->normalizar($_GET['tema']);
	$_GET['accion'] = SCRIPTS->normalizar(strtolower($_GET['accion']));
	$archivo_tema_confirmar = false;
	if ($_GET['accion'] == 'eliminar') {
		if(file_exists($archivo_tema)) { $archivo_tema_confirmar = unlink($archivo_tema); }
		if(file_exists(__DIR__ . "/web-tema.php") && $archivo_tema_confirmar) {
				$archivo_tema_confirmar = unlink(__DIR__ . "/web-tema.php"); }
	}
	if (file_exists($archivo_tema)) {
		switch($_GET['accion']) {
			case 'normalizar':
				if(file_exists(__DIR__ . '/web-tema.php')) {
					$archivo_tema_confirmar = unlink(__DIR__ . '/web-tema.php'); } break;
			case 'utilizar':
				$guardar = '<?php $Web["tema"] = ["tema" => "on", "archivo" => "'.(SCRIPTS->normalizar($_GET['tema'])).'"]; ?>';
				$archivo_tema_confirmar = file_put_contents(__DIR__ . "/web-tema.php", $guardar); break;
		}
	}
} ?>