<?php
# NUEVO SCRIPT
function ViewsPlantilla(string $File = null, bool $Elementos = false) { global $Web;
	if (!isset($Web['template']) || !isset($Web['template']['cantidad_contenedores']) ||
		!$Web['template']['cantidad_contenedores'] || isset($_GET['view'])) {
			return Daamper::views('main');
	}
	for ($i = 1; $i <= ($Web['template']['cantidad_contenedores'] ?? 1); $i++){	
		if (isset($Web['template']['tipo_contenedor_' . $i])) {
			if ($File !== null && $Web['template']['tipo_contenedor_' . $i] == $File) {
				$encontro['file'] = true;
			}
			if ($Web['template']['tipo_contenedor_' . $i] == 'main') {
				$encontro['main'] = true;
			}
		}
	}
	if (!isset($encontro['main'])) { Daamper::views('main'); return; }

	for ($i = 1; $i <= ($Web['template']['cantidad_contenedores'] ?? 0); $i++){
		if ($File !== null) {
			if (isset($Web['template']['tipo_contenedor_' . $i]) && $Web['template']['tipo_contenedor_' . $i] == $File) {
				ViewsPlantillaContenido ($File, $Elementos, $i);
				return;
			}
		} else {
			ViewsPlantillaContenido ($File, $Elementos, $i);
		}
	}
}

function ViewsPlantillaContenido ($File = null, bool $Elementos = false, int $i = 0) { global $Web;
	if (
		isset($Web['template']['mostrar_contenedor_' . $i]) &&
		!empty($Web['template']['mostrar_contenedor_' . $i])
	){
		echo isset($Web['template']['div_abrir_contenedor_'.$i]) ? PlantillaComandos($Web['template']['div_abrir_contenedor_'.$i], $i) : '';
		if (isset($Web['template']['tipo_contenedor_' . $i]) && $Web['template']['tipo_contenedor_' . $i] == 'main') {
			Daamper::views('main');
		} elseif ($File != null) {
			if(isset($Web['template']['tipo_contenedor_' . $i]) && $Web['template']['tipo_contenedor_' . $i] == $File){
				if (!$Elementos){ Daamper::views($Web['template']['tipo_contenedor_' . $i]); } else {
					ViewsPlantillaElementos($i);
				}
			}
		} else {
			if (!$Elementos){ Daamper::views($Web['template']['tipo_contenedor_' . $i]); } else {
				ViewsPlantillaElementos($i);
			}
		}
		echo isset($Web['template']['div_cerrar_contenedor_'.$i]) ? PlantillaComandos($Web['template']['div_cerrar_contenedor_'.$i], $i) : '';
	}
}

function ViewsPlantillaElementos ($i) { global $Web;
	if(isset($Web['template']['cantidad_elementos_contenedor_' . $i])) {
		for($ii = 1; $ii <= $Web['template']['cantidad_elementos_contenedor_' . $i]; $ii++){
			if(
				isset($Web['template']['mostrar_elemento_' . $ii . '_contenedor_' . $i]) &&
				!empty($Web['template']['mostrar_elemento_' . $ii . '_contenedor_' . $i])
				) {
					if (isset($Web['template']['estilos_campos_default_elemento_' . $ii . '_contenedor_' . $i])) {
						echo '<style type="text/css">';
						echo $Web['template']['estilos_campos_default_elemento_' . $ii . '_contenedor_' . $i];
						echo '</style>';
					}

					echo isset($Web['template']['div_abrir_campos_default_elemento_' . $ii . '_contenedor_' . $i]) && !empty($Web['template']['div_abrir_campos_default_elemento_' . $ii . '_contenedor_' . $i]) && !isset($Web['template']['ocultar_etiquetas_contenedor_campos_default_elemento_' . $ii . '_contenedor_' . $i]) ? PlantillaComandos($Web['template']['div_abrir_campos_default_elemento_' . $ii . '_contenedor_' . $i], $i, $ii) : (!isset($Web['template']['ocultar_etiquetas_contenedor_campos_default_elemento_' . $ii . '_contenedor_' . $i]) ? '<div>' : '');

					foreach (['titulo','contenido'] as $key => $value) {
						if(
							isset($Web['template'][$value . '_campos_default_elemento_' . $ii . '_contenedor_' . $i]) &&
							!empty($Web['template'][$value . '_campos_default_elemento_' . $ii . '_contenedor_' . $i])
							){
								echo $value == 'titulo' ? '<strong>' : '';
								echo PlantillaComandos($Web['template'][$value . '_campos_default_elemento_' . $ii . '_contenedor_' . $i], $i, $ii);
								echo $value == 'titulo' ? '</strong><hr>' : '';
						}
					}

					echo isset($Web['template']['div_cerrar_campos_default_elemento_' . $ii . '_contenedor_' . $i]) && !empty($Web['template']['div_cerrar_campos_default_elemento_' . $ii . '_contenedor_' . $i]) && !isset($Web['template']['ocultar_etiquetas_contenedor_campos_default_elemento_' . $ii . '_contenedor_' . $i]) ? PlantillaComandos($Web['template']['div_cerrar_campos_default_elemento_' . $ii . '_contenedor_' . $i], $i, $ii) : (!isset($Web['template']['ocultar_etiquetas_contenedor_campos_default_elemento_' . $ii . '_contenedor_' . $i]) ? '</div>' : '');
			}
		}
	}
}

function BuscarContenedorPlantilla(string $File, bool $SeEncuentra = false, $Contenido = null) { global $Web;
	$encontro = false;
	for ($i = 1; $i <= $Web['template']['cantidad_contenedores']; $i++){
		if (
			isset($Web['template']['cantidad_elementos_contenedor_' . $i]) &&
			isset($Web['template']['mostrar_contenedor_' . $i]) &&
			!empty($Web['template']['mostrar_contenedor_' . $i])
		){
			if($Web['template']['tipo_contenedor_' . $i] == $File) {
				$encontro = true; break;
			}
		}
	}

	if (!$SeEncuentra && !$encontro) { return $Contenido(); } elseif ($SeEncuentra && $encontro) { return $Contenido(); }
}

function PlantillaComandos ($string, $Contenedor, $Elemento = 1) { global $Web;
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

function PlantillaComandosReemplazar ($comando, $comando_valor, $comando_atributos, $Contenedor, $Elemento) { global $Web;
	if (in_array($comando, ['Form', 'Return', 'Post'])) {
        if (in_array($comando_valor, ['Input'])) {
			$comando_atributos['name'] = ($comando_atributos['name'] ?? 'empty') . "_elemento_{$Elemento}_contenedor_{$Contenedor}";
		}
		if (in_array($comando_valor, ['InputEnlace'])) {
			$comando_atributos['name'] = ($comando_atributos['name'] ?? 'empty');
		}
		if (in_array($comando_valor, ['Input','InputEnlace'])) {
			$comando_atributos['value'] = $Web['template']['scr'][$comando_atributos['name']] ?? '';
		}
		if (in_array($comando_valor, ['Post'])) {
			$comando_atributos['ruta'] = ($comando_atributos['ruta'] ?? '');
		}
	}
	if ($comando == 'Form') {
		switch ($comando_valor) {
			case 'Input':
				return pInput($comando_atributos);
				break;
			case 'InputEnlace':
				return pInputEnlace($Web, ['template','scr'], ['name' => $comando_atributos['name']], $Contenedor, $Elemento);
				break;
			
			default: return ''; break;
		}
	}
	if ($comando == 'Return') {
		foreach ([
			'Nombre', 'Enlace', 'Creador', 'CreadorNombreWeb' => 'creador_nombre_web',
			'CreadorEnlace' => 'creador_enlace', 'Anio', 'Version', 'Estado',
			'Creada', 'Mod', 'Version&Estado' => 'version_estado'
		] as $key => $value) {
			if($comando_valor == 'Web'.(is_string($key) ? $key : $value)) {
				$return = strtolower($value);
				return Daamper::$projectInfo->$return;
			}
		}

		switch ($comando_valor) {
			case 'NombreWeb': return $Web['config']['nombre_web'] ?? ''; break;
			case 'EnlaceWeb': return $Web['config']['enlace_web'] ?? ''; break;
			case 'Directorio': return $Web['directorio'] ?? './'; break;
			case 'Php': return $Web['config']['php'] ?? ''; break;
			case 'Copy': return '&copy; ' . (isset($Web['config']['ano_publicada']) && $Web['config']['ano_publicada'] != date("Y") ? $Web['config']['ano_publicada'] . ' -' : '') .' '. date("Y") . ' ' . ($Web['config']['nombre_web'] ?? '').'.'; break;
			#case 'WebVersion&Estado': return 'v'.Daamper::$projectInfo->version .' ' . Daamper::$projectInfo->estado; break;
			case 'WebVersionCompleta': return Daamper::$projectInfo->render(); break;
			case 'DevelopedBy': return Daamper::$projectInfo->developedBy(); break;
			case 'ElementoContenedor': return "_elemento_{$Elemento}_contenedor_{$Contenedor}" ?? ''; break;
			case 'WebVersionesOnline': return '<iframe frameborder="0" width="100%" style="min-height: 250px;" src="https://dbproject.rf.gd/main_external.php?tema='.($_SESSION['tmp']['color'] ?? $Web["config"]["color"] ?? 'light').'&cantidad=7&background=none&contenido=daamper-actualizaciones&font-size=14px&max-width=100%"></iframe>'; break;
			case 'Visitas': return Daamper::$data->Read('other/visits')['total'] ?? 0; break;
			case 'Iframe':
				$comando_atributos['get'] = isset($comando_atributos['get']) ? '?' . str_replace('~', '=', $comando_atributos['get']) : '';
				if (substr($comando_atributos['src'], 0, 4) != 'http') {
					$comando_atributos['src'] = $Web['directorio'] . $comando_atributos['src'];
					if (!file_exists($comando_atributos['src'])) { return; }
				}
				return '<iframe style="width: 100%; height: '.($comando_atributos['height'] ?? '100%').';" src="'.$comando_atributos['src'].$comando_atributos['get'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>'; break;
			case 'FileReturn':
			case 'FileReturnVersion':
				$comando_atributos['src'] = $comando_atributos['src'] ?? '';
				if (substr($comando_atributos['src'], 0, 4) != 'http') {
					$comando_atributos['src'] = $Web['directorio'] . $comando_atributos['src'];
					if (!file_exists($comando_atributos['src'])) { return; }
				}
				$string = file_get_contents($comando_atributos['src']);
				foreach (['salto', 'espacio'] as $valor) {
					if (isset($comando_atributos[$valor]) && $comando_atributos[$valor] == true) {
						$string = $valor == 'salto' ? Daamper::$scripts->saltoToBr($string) : Daamper::$scripts->espacios_left($string);
					}
				}
				if ($comando_valor == 'FileReturnVersion') {
					$string = str_replace('-> ', '<i class="fas fa-file-code"></i> ', $string);
        			$string = str_replace('- ', '<i class="fas fa-folder-open"></i> ', $string);
				}
				return $string;
				break;
			case 'InputEnlace':
				return EnlaceExtructura($Web, ['template','scr'], ['name' => $comando_atributos['name'], 'solo' => $comando_atributos['solo'] ?? '', 'class' => $comando_atributos['class'] ?? ''], isset($comando_atributos['contenedor']) ? $comando_atributos['contenedor'] : $Contenedor, isset($comando_atributos['elemento']) ? $comando_atributos['elemento'] : $Elemento);
				break;
            case 'InputEnlaceSesion':
				return isset($_SESSION['id']) ? EnlaceExtructura($Web, ['template','scr'], ['name' => $comando_atributos['name'], 'solo' => $comando_atributos['solo'] ?? '', 'class' => $comando_atributos['class'] ?? ''], isset($comando_atributos['contenedor']) ? $comando_atributos['contenedor'] : $Contenedor, isset($comando_atributos['elemento']) ? $comando_atributos['elemento'] : $Elemento) : '<i hidden></i>';
				break;
            case 'InputEnlaceNoSesion':
				return !isset($_SESSION['id']) ? EnlaceExtructura($Web, ['template','scr'], ['name' => $comando_atributos['name'], 'solo' => $comando_atributos['solo'] ?? '', 'class' => $comando_atributos['class'] ?? ''], isset($comando_atributos['contenedor']) ? $comando_atributos['contenedor'] : $Contenedor, isset($comando_atributos['elemento']) ? $comando_atributos['elemento'] : $Elemento) : '<i hidden></i>';
				break;
			case 'InputEnlaceNoPanel':
				return $Web['ruta_completa'] != '../admin/admin.php' ? EnlaceExtructura($Web, ['template','scr'], ['name' => $comando_atributos['name'], 'solo' => $comando_atributos['solo'] ?? '', 'class' => $comando_atributos['class'] ?? ''], isset($comando_atributos['contenedor']) ? $comando_atributos['contenedor'] : $Contenedor, isset($comando_atributos['elemento']) ? $comando_atributos['elemento'] : $Elemento) : '<i hidden></i>';
				break;
		}

		return 'Fallo al leer el comando<i hidden></i>';
	}
	if ($comando == 'View') {
		if (file_exists($Web['directorio'].Daamper::viewsPath($comando_valor))) { require $Web['directorio'].Daamper::viewsPath($comando_valor); }
		return '<i hidden></i>';
	}
}
