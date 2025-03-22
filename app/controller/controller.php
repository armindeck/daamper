<?php #21/06/2024 ~ 10:39pm
session_start();
require_once __DIR__.'/recursos.php';
require_once __DIR__.'/system.php';
require_once $Web['directorio'].AppScripts();
require_once __DIR__.'/portabilidad.php';

if (!isset($CONTROL_PROCESA)) {
	foreach ([AppHttp(), AppContent(), AppDatabase(), AppViews()] as $value) {
		require_once $Web['directorio'] . $value;
	}
}