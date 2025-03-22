<?php /*
function PlantillaRedesSocialesDisplaNumero($keylocal){
	$posicion_numero=strrpos($keylocal, '_')+1;
	$posicion_numero_eliminar_restar=strlen($keylocal)-$posicion_numero;
	$numero = substr($keylocal, $posicion_numero);
	//echo substr($keylocal2, $posicion_numero).': '.$valuelocal2.'<br>';
	return $numero;
}

function PlantillaRedesSocialesDisplaIconoTexto($Web, $Apartado, $list){
	if(isset($Web[$Apartado]) && isset($Web['plantilla']['scr'][$list['name']]) && !empty($Web['plantilla']['scr'][$list['name']])){
		foreach ($Web[$Apartado] as $keylocal => $valuelocal) {
			if(is_array($Web[$Apartado][$keylocal])){
				if(isset($Web['plantilla']['scr'][$list['name'].'_'.$keylocal]) && !empty($Web['plantilla']['scr'][$list['name'].'_'.$keylocal])){
					$numero = PlantillaRedesSocialesDisplaNumero($keylocal);

					echo '<li><a target="_blank" href="'.($valuelocal['enlace_web_'.$numero]).'"><i class="'.($valuelocal['icono_web_'.$numero]).'"></i> ';

					if(!empty($valuelocal['nombre_usuario_web_'.$numero])){
						echo $valuelocal['nombre_usuario_web_'.$numero];
					} elseif (!empty($valuelocal['nombre_web_'.$numero])){
						echo $valuelocal['nombre_web_'.$numero];
					}
					echo '</a></li>';
				}
			}
		}
	}
}

function PlantillaRedesSocialesDisplaIcono($Web, $Apartado, $list){
	if(isset($Web[$Apartado]) && isset($Web['plantilla']['scr'][$list['name']]) && !empty($Web['plantilla']['scr'][$list['name']])){
		echo '<div>';
		foreach ($Web[$Apartado] as $keylocal => $valuelocal) {
			if(is_array($Web[$Apartado][$keylocal])){
				$numero = PlantillaRedesSocialesDisplaNumero($keylocal);
				if(isset($Web['plantilla']['scr'][$list['name'].'_'.$keylocal]) && !empty($Web['plantilla']['scr'][$list['name'].'_'.$keylocal])){
					echo '<a target="_blank" href="'.($valuelocal['enlace_web_'.$numero]).'"><i class="'.($valuelocal['icono_web_'.$numero]).'"></i></a> ';
				}
			}
		}
		echo '</div>';
	}
}

function PlantillaRedesSocialesPlantillaIcono($Web, $Apartado, $list){
	if(isset($Web[$Apartado])){
		foreach ($Web[$Apartado] as $keylocal => $valuelocal) {
			if(is_array($Web[$Apartado][$keylocal])){
				$numero = PlantillaRedesSocialesDisplaNumero($keylocal);
				echo pCheckboxBotonActivoDesaptivo($Web, ['plantilla','scr'],
					[
						'nameidclass'=>$list['name'].'_'.($keylocal),
						'texto2'=>'<i class="'.($valuelocal['icono_web_'.$numero]).'"></i>',
						'title'=>'Se mostrara/ocultara el '.($valuelocal['nombre_web_'.$numero]).' de '.($valuelocal['nombre_usuario_web_'.$numero])
					]
				);
			}
		}
	}
}
?>
<?php function PlantillaComandos3 ($string) { global $Web;
	$lista = require __DIR__.'/comandos2.php';

	$return = $string;
	foreach ($lista as $key => $value) {
		foreach ($value as $key2 => $value2) {
			$return = str_replace("[$key=$key2]", $value2, $return);
		}
	}
	return $return;
} ?>

<?php /*function PlantillaComandos ($string, $Contenedor, $Elemento = 1) { global $Web;
	$Form['enlace'] = pInputEnlace($Web, ['plantilla','scr'], [], $Contenedor, $Elemento);
	$Form['campo'] = pInput(['value'=>'']);
	$Item['enlace'] = EnlaceExtructura($Web, ['plantilla','scr'], [], $Contenedor, $Elemento);
	$Item['enlace_sesion'] = isset($_SESSION['id']) ? EnlaceExtructura($Web, ['plantilla','scr'], [], $Contenedor, $Elemento) : '';
	$Item['enlace_no_sesion'] = !isset($_SESSION['id']) ? EnlaceExtructura($Web, ['plantilla','scr'], [], $Contenedor, $Elemento) : '';
	$lista = [
		['View', 'header-estatico'],
		['View', 'article'],
		['Return', 'NombreWeb', $Web['config']['nombre_web']],
		['Return', 'EnlaceWeb', $Web['config']['enlace_web']],
		['Return', 'Contenedor', "$Contenedor"],
		['Return', 'Elemento', "$Elemento"],
		['Form', 'Enlace', $Form['enlace']],
		['Form', 'Campo', $Form['campo']],
		['Elemento', 'Enlace', $Item['enlace']],
		['Elemento', 'EnlaceSesion', $Item['enlace_sesion']],
		['Elemento', 'EnlaceNoSesion', $Item['enlace_no_sesion']],
	];
	foreach ($lista as $key => $value) {
		$string = str_ireplace("<{$value[0]}={$value[1]} />", $value[0] == 'View' ? file_get_contents($Web['directorio'].AppViews($value[1])) : (is_string($value[2]) ? $value[2] : $value[2]()), $string);
	}
	return $string;
}*/?>