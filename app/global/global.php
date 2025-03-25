<?php require_once __DIR__ . '/get.php';
foreach ([
	'usuario', 'routes/auth', 'routes/panel'
	] as $value) { require_once __DIR__ . "/{$value}.php"; }
if ($Web['ruta_completa'] == '../p/perfil.php') { header("Location: ../auth/iniciar.php"); }

Ruta(null,
		$Web['ruta_completa'] != '../panel/panel.php' &&
		$Web['ruta_completa'] != '../panel/procesa/procesa.creador.borrador.php',
	function () use ($Web) {
		if(!isset($_SESSION['rol']) or isset($_SESSION['rol']) && strtolower($_SESSION['rol']) != 'ceo founder'){
			CrearCarpetas('database/other/');
			$file = $Web['directorio'].'database/other/count.json';
			$leer = Database("other/count");
			$leer['total'] = AumentarJSON($leer, 'total');
			$leer[$Web['ruta']] = AumentarJSON($leer, $Web['ruta']);

			file_put_contents($file, json_encode($leer));
		}
}); ?>