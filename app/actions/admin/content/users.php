<?php
$lista = ["estado", "rol"];
$usuarios = Daamper::$data->User();
$rol_permitido = [
	"CEO Founder" => ["Usuario", "Editor", "Administrador", "CEO Founder"],
	"Administrador" => ["Usuario", "Editor"]
];
$lista_ceos = 0;
$lista_ceos_nuevo = 0;
foreach ($usuarios as $key => $datos) {
	if(strtolower($datos["rol"]) == "ceo founder"){
		$lista_ceos += 1;
	}
	if(isset($_POST["rol-us-{$datos['id']}"]) && strtolower($_POST["rol-us-{$datos['id']}"]) == "ceo founder"){
		$lista_ceos_nuevo += 1;
	}
}
//echo "CEOS: $lista_ceos, NUEVOS: $lista_ceos_nuevo";

foreach ($usuarios as $id => $datos) {
	foreach ($datos as $key => $value) {
		if (in_array($key, $lista)){
			if (isset($_POST["$key-us-{$datos['id']}"]) && !empty($_POST["$key-us-{$datos['id']}"])){
				$pasa = false;
				if(strtolower($_SESSION["rol"]) == "ceo founder"){
					$pasa = true;
					if($lista_ceos_nuevo === 0 && strtolower($usuarios[$datos["id"]]["rol"]) == "ceo founder"){
						$pasa = false;
					}
				}

				if (strtolower($_SESSION["rol"]) == "administrador"){
					if(
						in_array($_POST["rol-us-{$datos['id']}"], $rol_permitido[$_SESSION["rol"]]) &&
						!in_array($usuarios[$datos["id"]]["rol"], ["Administrador", "CEO Founder"])
					){
						$pasa = true;
					}
				}
				if($pasa){
					$usuarios[$datos["id"]][$key] = Daamper::$scripts->normalizar($_POST["$key-us-{$datos['id']}"]);
					if ($key == "estado"){
						$usuarios[$datos["id"]][$key] = strtolower($usuarios[$datos["id"]][$key]);
					}
				}
			}
		}
	}
}

function Historial($status = false) {
	$file = RAIZ . "database/files/txt/history/users.txt";
	if (!file_exists($file)) { file_put_contents($file, 'Generado: ' . Daamper::$scripts->fecha_hora()); }
	$leer = file_get_contents($file);
	$guardar = Daamper::$scripts->fecha_hora() . ' ~ '.($status ? 'Modificado' : 'Fallo').' → ' . $_SESSION['id'];
	file_put_contents($file, "$guardar\n$leer");
}

$confirmar = Daamper::$data->UpdateUser($usuarios);

if(!$confirmar){
	Historial(false);
	Daamper::$sendAlert->Error(Language('data-no-save'), "../admin.php?ap=$Apartado");
}

Historial(true);
Daamper::$sendAlert->Success(Language('data-save'), "../admin.php?ap=$Apartado");

$DATOS_DEFAULT = false;