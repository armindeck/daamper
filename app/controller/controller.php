<?php # 21/06/2024 ~ 10:39pm ~ Create file
// Copyright (c) 2025 daamper
// Licencia: Uso No Transferible - Prohibida la venta del código.
// Para más detalles, consulta el archivo LICENSE.txt en la raíz del proyecto.
session_start();
require_once __DIR__.'/daamper.php';
require_once __DIR__.'/../scripts/scripts.php';
require_once __DIR__.'/folder.php';
require_once __DIR__.'/../model/model.php';
require_once __DIR__.'/normalize-web.php';

if (!isset($PROCESS_ADMIN)) {
	require_once RAIZ . Daamper::globalPath();
	require_once RAIZ . Daamper::contentPath();
	require_once RAIZ . Daamper::viewsPath();
}