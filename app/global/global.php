<?php require_once __DIR__ . '/get.php';
foreach ([
	'usuario', 'routes/auth', 'routes/admin', 'routes/api'
	] as $value) { require_once __DIR__ . "/{$value}.php"; }
if ($Web['ruta_completa'] == '../p/perfil.php') { header("Location: ../auth/login.php"); }

Ruta(null,
		$Web['ruta_completa'] != '../admin/admin.php' &&
		$Web['ruta_completa'] != '../admin/process/creator.php',
	function () use ($Web) {
		if(!isset($_SESSION['rol']) or isset($_SESSION['rol']) && strtolower($_SESSION['rol']) != 'ceo founder'){
			CrearCarpetas('database/other/');
			$file = $Web['directorio'].'database/other/visits.json';
			$leer = DATA->Read("other/visits");
			$leer['total'] = AumentarJSON($leer, 'total');
			$leer[$Web['ruta']] = AumentarJSON($leer, $Web['ruta']);

			DATA->Save("other/visits", $leer);
		}
}); ?>