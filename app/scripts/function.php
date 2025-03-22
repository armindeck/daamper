<?php
function Ruta($Tipo = null, $Ruta, $Contenido) {
	if (is_string($Ruta)){ global $Web;
        # RUTA 100% ORIGINAL -> GET - POST
		if ($Tipo == null && $Web['ruta_completa'] == $Ruta) {
			return $Contenido();
		} else if ($Tipo == 'AX') { global $AX;
            # RUTA ORIGINAL SIN -> GET - POST
			if ($Ruta == $AX['ruta'].$AX['archivo']) {
				return $Contenido();
			}
		}
	} else if ($Ruta) { # RUTA LIBRE POR CONDICION
		return $Contenido();
	}
}

function FormComentario (string $string = null) { global $AX, $Web;
	foreach (['comentar' => 'form-comentar', 'comentarios' => 'comentarios'] as $key => $value) {
		$mostrar = false;
		if (
			isset($AX[$key]) && !empty($AX[$key]) &&
			$Web['ruta_completa'] !== '../panel/procesa/procesa.creador.borrador.php'){ $mostrar = true; }
		if ($Web['ruta_completa'] == '../panel/panel.php' && isset($_GET['ap']) && $_GET['ap'] == 'comentarios' && $string !== null) { $mostrar = true; }
		if ($mostrar) {
			Views("main/{$value}");
		}
	}
}

function EliminarLinea($filename, $coincidencia) {
    $lineToDelete = $coincidencia;

    // Leer todo el contenido del archivo en una variable
    $fileContents = file($filename);

    // Filtrar las líneas que no contienen la coincidencia
    $filteredContents = array_filter($fileContents, function($line) use ($lineToDelete) {
        return strpos($line, $lineToDelete) === false;
    });

    return implode("", $filteredContents);
}

function ImagenesACX($AC = [], $defecto = false, $lista = ['poster','poster_url','miniatura','miniatura_url']) { global $Web;
	foreach ($lista as $imagen) {
		if (ConfirmarImagen($imagen, $AC)) { return ConfirmarImagen($imagen, $AC); }
	} return $defecto === true ? $Web['directorio'].AssetsImg('miniatura.png') :
		(!is_bool($defecto) ? $defecto : '');
}

function ConfirmarImagen ($imagen, $AC = []) { global $Web;
	if (!isset($AC[$imagen]) || empty($AC[$imagen])) { return false; }
	if (substr($AC[$imagen], 0, 4) == 'http') { return $AC[$imagen]; }
	return file_exists($Web['directorio'].$AC[$imagen]) ? $Web['config']['https_imagen'] . $AC[$imagen] : false;
}

function AumentarJSON(array $leer, string $value, int $aumentar = 1){
	if (!isset($leer[$value]) || empty($leer[$value])) { $leer[$value] = 0; }
	return $leer[$value] + $aumentar;
}

function CrearCarpetas(string $ruta){ global $Web;
	if ($ruta[-1] != '/') { $ruta .= '/'; }
	if(!file_exists($Web['directorio'].$ruta)){
		if(mkdir($Web['directorio'].$ruta, 0777, true));
	}
}