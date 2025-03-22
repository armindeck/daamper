<?php # 08/01/2025 - 12:47am
$post = []; $busca = [];
$guardar = "<?php #".(SCRIPTS->fecha_hora())."\n";
require_once $Web['directorio'] . AppDatabase();

$lista['oficial'] = ['nombre', 'usuario', 'email', 'contrasena', 'id', 'estado', 'rol', 'fecha_registrado'];
$lista['opcional'] = ['contrasena', 'id', 'fecha_registrado'];

foreach (usu as $key => $value) {
	$guardar .= '$'."usu[{$value['id']}] = [";
	foreach ($value as $key_2 => $value_2) {
		if (in_array($key_2, $lista['oficial'])){
			if (!in_array($key_2, $lista['opcional'])) {
				$vstring = "{$key_2}-us-{$value['id']}";
				$busca[$vstring] = isset($_POST[$vstring]) ? SCRIPTS->normalizar($_POST[$vstring]) : '';
				if ($key_2 == 'estado') { $busca[$vstring] = strtolower($busca[$vstring]); }
				$post[$value['id']][$key_2] = !empty($busca[$vstring]) ? $busca[$vstring] : $value_2;
			} else {
				$post[$value['id']][$key_2] = $value_2;
			}
			
			$guardar .= "'$key_2' => ";

			$guardar .= $key_2 != 'id' ? "'" : '';
			$guardar .= $post[$value['id']][$key_2];
			$guardar .= $key_2 != 'id' ? "'" : '';

			$guardar .= ', ';

		}
	}
	$guardar .= "];\n";
}

$guardar .= "?>";

function Historial($if = false) {
	$file = __DIR__.'/historial.txt';
	if (!file_exists($file)) {
		file_put_contents($file, 'Generado: ' . SCRIPTS->fecha_hora());
	}
	$leer = file_get_contents($file);
	$guardar = SCRIPTS->fecha_hora() . ' ~ '.($if ? 'Modificado' : 'Fallo').' -> ' . $_SESSION['id'];
	file_put_contents($file, "$guardar\n$leer");
}

$confirmar = file_put_contents("../../app/database/usuarios/usuarios.php", $guardar);

if($confirmar){
	Historial(true);
	mensajeSpan(['bg'=>'green','text'=>(LANGUAJE['global']['data-save'][CONFIG['languaje']]),'ruta'=>"../panel.php?ap=$Apartado"]);
} else {
	Historial(false);
	mensajeSpan(['bg'=>'red','text'=>(LANGUAJE['global']['data-no-save'][CONFIG['languaje']]),'ruta'=>"../panel.php?ap=$Apartado"]);
}

$DATOS_DEFAULT = false;
?>