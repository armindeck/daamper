<?php function PlantillaComandosReemplazar ($comando, $comando_valor, $comando_atributos, $Contenedor, $Elemento) { global $Web, $WEBSITE;
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
	if ($comando == 'Post') {
		switch ($comando_valor) {
			case 'all':
				#return ApiData('all');
				break;
			case 'specific':
				#return ApiData($comando_atributos);
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
				return $WEBSITE->$return;
			}
		}

		switch ($comando_valor) {
			case 'NombreWeb': return $Web['config']['nombre_web'] ?? ''; break;
			case 'EnlaceWeb': return $Web['config']['enlace_web'] ?? ''; break;
			case 'Directorio': return $Web['directorio'] ?? './'; break;
			case 'Php': return $Web['config']['php'] ?? ''; break;
			case 'Copy': return '&copy; ' . (isset($Web['config']['ano_publicada']) && $Web['config']['ano_publicada'] != date("Y") ? $Web['config']['ano_publicada'] . ' -' : '') .' '. date("Y") . ' ' . ($Web['config']['nombre_web'] ?? '').'.'; break;
			#case 'WebVersion&Estado': return 'v'.$WEBSITE->version .' ' . $WEBSITE->estado; break;
			case 'WebVersionCompleta': return $WEBSITE->web(); break;
			case 'ElementoContenedor': return "_elemento_{$Elemento}_contenedor_{$Contenedor}" ?? ''; break;
			case 'WebVersionesOnline': return '<iframe frameborder="0" width="100%" style="min-height: 250px;" src="https://dbproject.rf.gd/main_external.php?tema='.(isset($_SESSION['tmp']['tema']) ? $_SESSION['tmp']['tema'] : 'blue-aero').'&cantidad=7&background=none&contenido=daamper-actualizaciones&font-size=14px&max-width=100%"></iframe>'; break;
			case 'Visitas': return DATA->Read('other/visits')['total'] ?? 0; break;
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
						$string = $valor == 'salto' ? SCRIPTS->saltoToBr($string) : SCRIPTS->espacios_left($string);
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
		if (file_exists($Web['directorio'].AppViews($comando_valor))) { require $Web['directorio'].AppViews($comando_valor); }
		return '<i hidden></i>';
	}
} ?>