<?php # 21/06/2024 ~ 10:39pm ~ Create file
// Copyright (c) 2025 daamper
// Licencia: Uso No Transferible - Prohibida la venta del código.
// Para más detalles, consulta el archivo LICENSE.txt en la raíz del proyecto.
session_start();
require_once __DIR__.'/recursos.php';
require_once __DIR__.'/system.php';
require_once __DIR__.'/../scripts/scripts.php';
require_once __DIR__.'/folder.php';
require_once __DIR__.'/../model/model.php';
require_once __DIR__.'/portabilidad.php';

if (!isset($PROCESS_ADMIN)) {
	foreach ([AppGlobal(), AppContent(), AppViews()] as $value) {
		require_once RAIZ . $value;
	}
}