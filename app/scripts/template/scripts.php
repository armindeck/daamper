<?php function PlantillaComandos ($string, $Contenedor, $Elemento = 1) { global $Web;
	$patron = '/\[(Form|View|Return|Post)=([^>]+)(?:\s+(name|placeholder|required|value|type)="([^"]+)")*\]/';
	
	preg_match_all($patron, $string, $coincidencias);
	$datos = $string;
	#print_r($coincidencias[0]);
	foreach ($coincidencias[1] as $i => $cadena) {
		$comando = explode(' ', $cadena);
		$comando = $comando[0];
		$comando_valor = explode(' ', $coincidencias[2][$i]);
		$comando_valor = trim($comando_valor[0]);
			#echo "<strong><font color='yellow'>$comando: $comando_valor ~ ".strlen($comando_valor)."</font></strong><br>";
		$comando_elementos = trim(substr($coincidencias[2][$i], strpos($comando_valor, $coincidencias[2][$i]) + strlen($comando_valor)));
			#echo !empty($comando_elementos) ? "<font color='orangered'>$comando_elementos</font><br>" : '';
		
		$comando_atributos = [];
		if (!empty($comando_elementos)) {
			$atributos = explode(' ', $comando_elementos);
			foreach ($atributos as $atributo) {
				if (!empty($atributo)) {
					list($clave, $valor) = explode('=', $atributo);
					$comando_atributos[trim($clave)] = trim(trim($valor, '"'), "'");
				}
			}
		}
		
		$datos = str_ireplace("[$comando=$comando_valor". (!empty($comando_elementos) ? ' '.$comando_elementos : ''). "]", PlantillaComandosReemplazar($comando, $comando_valor, $comando_atributos, $Contenedor, $Elemento), $datos);
	}
	
	return !empty($datos) ? $datos : $string;
} 

require_once __DIR__ . '/comandos.php'; ?>