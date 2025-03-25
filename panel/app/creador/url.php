<?php

if (isset($_GET['tipo']) && !empty($_GET['tipo'])) {
	$Global['get_tipo'] = SCRIPTS->normalizar2($_GET['tipo']);
} else {
	$Global['get_tipo'] = '';
}

if (isset($_GET['archivo']) && !empty($_GET['archivo'])) {
	$Global['get_archivo'] = SCRIPTS->normalizar2($_GET['archivo']);
} else {
	$Global['get_archivo'] = '';
}

if (isset($_POST['refrescar']) && !empty($_POST['refrescar'])) {
	$ruta_get = '?ap=creador';
	$ruta_get .= isset($_GET['creador']) ? '&creador=' . SCRIPTS->normalizar2($_GET['creador']) : '';
	$ruta_get .= isset($_GET['tipo']) ? '&tipo=' . SCRIPTS->normalizar2($_GET['tipo']) : '';
	$ruta_get .= isset($_GET['archivo']) ? '&archivo=' . SCRIPTS->normalizar2($_GET['archivo']) : '';
	mensajeSpan(['bg' => 'rgb(64,255,255)', 'co' => '#000', 'text' => Language('refreshed'), 'ruta' => $ruta_get, 'tmpForm' => $_POST]);
}
if (isset($_POST['mostrar']) && !empty($_POST['mostrar'])) {
	$_SESSION['tmpForm'] = $_POST;
	$_SESSION['instance_destroy'] = true;
	header("Location: procesa/procesa.creador.borrador.php");
	exit;
}

if (
	isset($_POST['publicacion']) && !empty($_POST['publicacion']) ||
	isset($_POST['borrador']) && !empty($_POST['borrador'])
) {
	if (isset($_POST['publicacion'])) {
		$Creador['tipo'] = 'publicacion';
	}
	if (isset($_POST['borrador'])) {
		$Creador['tipo'] = 'borrador';
	}
	header("Location: ?ap=creador&creador=normal&tipo={$Creador['tipo']}&archivo={$_POST[$Creador['tipo']]}");
	exit;
}

if (
	isset($_GET['creador']) && !empty($_GET['creador']) &&
	isset($_GET['tipo']) && !empty($_GET['tipo']) &&
	isset($_GET['archivo']) && !empty($_GET['archivo'])
) {
	$Creador['get_creador'] = SCRIPTS->normalizar2($_GET['creador']);
	$Creador['get_tipo'] = SCRIPTS->normalizar2($_GET['tipo']);
	$Creador['get_archivo'] = SCRIPTS->normalizar2($_GET['archivo']);

	if ($Creador['get_tipo'] == 'publicacion' || $Creador['get_tipo'] == 'borrador') {
		if ($Creador['get_tipo'] == 'publicacion') {
			$Creador['ruta_archivo'] = 'app/database/publicaciones/';
		}
		if ($Creador['get_tipo'] == 'borrador') {
			$Creador['ruta_archivo'] = 'panel/app/creador/borradores/';
		}
		$ruta_archivo = $Web['directorio'] . $Creador['ruta_archivo'] . $Creador['get_archivo'];
		if (!file_exists($ruta_archivo)) {
			mensajeSpan(['bg' => 'red', 'text' => Language('file-no-exists', 'global', ['value' => '<strong>' . $Creador['get_archivo'] . '</strong>']), 'ruta' => "?ap=creador"]);
		}
		require $ruta_archivo;
		if (!isset($ACR['creador'])) {
			mensajeSpan(['bg' => 'red', 'text' => Language('file-exists-no-data-or-incomplete', 'alert'), 'ruta' => "?ap=creador"]);
		}
		$Creador['lista_datos_necesarios'] = ['creador', 'db_ruta'];
		foreach ($Creador['lista_datos_necesarios'] as $key => $value) {
			if (!isset($ACR[$value])) {
				mensajeSpan(['bg' => 'red', 'text' => Language('file-no-data-creator-or-ruta', 'alert'), 'ruta' => "?ap=creador"]);
			}
		}
		if ($Creador['get_creador'] != $ACR['creador']) {
			header("Location: ?ap=creador&creador={$ACR['creador']}&tipo={$Creador['get_tipo']}&archivo={$Creador['get_archivo']}");
		}
		if (!isset($_SESSION['tmpForm'])) {
			$Creador['tmp'] = [];
			foreach ($AC as $key => $value) {
				$Creador['tmp'][$key] = $value;
			}
			foreach ($ACR as $key => $value) {
				if ($key != 'db_ruta' || $key != 'id_publicador') {
					$Creador['tmp'][$key] = $value;
				}
			}
			$_SESSION['tmpForm'] = $Creador['tmp'];
		}
	}
	unset($Creador['get_tipo']);
	unset($Creador['get_creador']);
	unset($Creador['get_archivo']);
	unset($Creador['ruta_archivo']);
	unset($Creador['tmp']);
	unset($Creador['lista_datos_necesarios']);
	unset($ACR);
	unset($AC);
}

if (isset($_GET['actualizar-entradas']) && isset($_GET['cantidad-entradas']) && !empty($_GET['cantidad-entradas'])) {
	$guardar = "<?php return [\n";

	for ($j = 0; $j < SCRIPTS->normalizar2($_GET['cantidad-entradas']); $j++) {
		$guardar .= "['entrada' => '" . (strtolower($_GET["entrada-$j"] ?? '')) . "', 'poster' => '" . ($_GET["entrada-poster-$j"] ?? '') . "', 'titulo' => '" . ($_GET["entrada-titulo-$j"] ?? '') . "', 'titulo-alternativo' => '" . ($_GET["entrada-titulo-alternativo-$j"] ?? '') . "'],\n";
	}
	$guardar .= "];";

	$funciona = file_put_contents(__DIR__ . '/creadores/normal/function/lista-publicaciones.php', $guardar);
	if (!$funciona) {
		mensajeSpan(['bg' => 'red', 'text' => Language('data-no-save'), 'ruta' => "panel.php?ap=creador"]);
	}
	mensajeSpan(['bg' => 'green', 'text' => Language('data-save'), 'ruta' => "panel.php?ap=creador"]);
}
