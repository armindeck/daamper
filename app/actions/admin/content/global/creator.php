<?php
if (isset($_GET['tipo']) && !empty($_GET['tipo'])) {
	$Global['get_tipo'] = Daamper::$scripts->normalizar2($_GET['tipo']);
} else {
	$Global['get_tipo'] = '';
}

if (isset($_GET['archivo']) && !empty($_GET['archivo'])) {
	$Global['get_archivo'] = Daamper::$scripts->normalizar2($_GET['archivo']);
} else {
	$Global['get_archivo'] = '';
}

if (isset($_POST['refrescar']) && !empty($_POST['refrescar'])) {
	$ruta_get = '?ap=creator';
	$ruta_get .= isset($_GET['creador']) ? '&creador=' . Daamper::$scripts->normalizar2($_GET['creador']) : '';
	$ruta_get .= isset($_GET['tipo']) ? '&tipo=' . Daamper::$scripts->normalizar2($_GET['tipo']) : '';
	$ruta_get .= isset($_GET['archivo']) ? '&archivo=' . Daamper::$scripts->normalizar2($_GET['archivo']) : '';
	Daamper::$sendAlert->Refresh(Language('refreshed'), $ruta_get, $_POST);
}
if (isset($_POST['mostrar']) && !empty($_POST['mostrar'])) {
	$_SESSION['tmpForm'] = $_POST;
	$_SESSION['instance_destroy'] = true;
	header("Location: process/creator.php");
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
	header("Location: ?ap=creator&creador=normal&tipo={$Creador['tipo']}&archivo={$_POST[$Creador['tipo']]}");
	exit;
}

if (
	isset($_GET['creador']) && !empty($_GET['creador']) &&
	isset($_GET['tipo']) && !empty($_GET['tipo']) &&
	isset($_GET['archivo']) && !empty($_GET['archivo'])
) {
	$Creador['get_creador'] = Daamper::$scripts->normalizar2($_GET['creador']);
	$Creador['get_tipo'] = Daamper::$scripts->normalizar2($_GET['tipo']);
	$Creador['get_archivo'] = Daamper::$scripts->normalizar2($_GET['archivo']);

	if ($Creador['get_tipo'] == 'publicacion' || $Creador['get_tipo'] == 'borrador') {
		if ($Creador['get_tipo'] == 'publicacion') {
			$Creador['ruta_archivo'] = 'database/post/';
		}
		if ($Creador['get_tipo'] == 'borrador') {
			$Creador['ruta_archivo'] = 'database/draft/';
		}
		$ruta_archivo = RAIZ . $Creador['ruta_archivo'] . $Creador['get_archivo'];
		if (!file_exists($ruta_archivo)) {
			Daamper::$sendAlert->Error(Language('file-no-exists', 'global', ['value' => '<strong>' . $Creador['get_archivo'] . '</strong>']), "?ap=creator");
		}
		$ACR = Daamper::$data->Read(($Creador['get_tipo'] == "publicacion" ? "post" : "draft") . "/" . $Creador['get_archivo'])["ACR"];
		$AC = Daamper::$data->Read(($Creador['get_tipo'] == "publicacion" ? "post" : "draft") . "/" . $Creador['get_archivo'])["AC"];
		if (!isset($ACR['creador'])) {
			Daamper::$sendAlert->Error(Language('file-exists-no-data-or-incomplete', 'alert'), "?ap=creator");
		}
		$Creador['lista_datos_necesarios'] = ['creador', 'db_ruta'];
		foreach ($Creador['lista_datos_necesarios'] as $key => $value) {
			if (!isset($ACR[$value])) {
				Daamper::$sendAlert->Error(Language('file-no-data-creator-or-ruta', 'alert'), "?ap=creator");
			}
		}
		if ($Creador['get_creador'] != $ACR['creador']) {
			header("Location: ?ap=creator&creador={$ACR['creador']}&tipo={$Creador['get_tipo']}&archivo={$Creador['get_archivo']}");
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
