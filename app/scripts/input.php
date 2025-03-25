<?php
function exLabel($list) {
	$return = '';
	if(isset($list['label']) && $list['label']){
		$return .= '<label for="';
		if(isset($list['id'])){
			$return .= $list['id'];
		} else {
			$return .= isset($list['name']) ? $list['name'] : '';
		}
		$return .= '"';
		$return .= isset($list['title']) ? ' title="'.$list['title'].'"' : '';
		$return .= isset($list['class_label']) ? ' class="'.$list['class_label'].'"' : ''; 
		$return .= '>'.(isset($list['texto']) ? '<span>'.$list['texto'].':</span> ' : '');
	}
	# $return .= isset($list['label']) && $list['label'] ? '</label>' : '';
	return $return;
}
function pInput($list){
	$return = exLabel($list);

	$return .= '<input ';
	#TODO

	if(!isset($list['type'])){ $list['type']='text'; }
	$return .= 'type="'. (isset($list['type']) ? $list['type'] : 'text'). '"';
	$return .= ' name="'. (isset($list['name']) ? $list['name'] : ''). '"';

	$return .= ' id="';
	if(isset($list['id'])){
		$return .= $list['id'];
	} else {
		$return .= isset($list['name']) ? $list['name'] : '';
	}
	$return .= '"';

	$return .= ' value="';
	if(isset($_SESSION['tmpForm']) && $list['type']!='password'){
		if(!isset($list['des_session']) or !$list['des_session']){
			foreach ($_SESSION['tmpForm'] as $key => $value) {
				if($key==$list['name']){
					$return .= $value;
					break;
				}
			}
		} else {
			$return .= isset($list['value']) ? $list['value'] : '';
		}
	} else {
		$return .= isset($list['value']) ? $list['value'] : '';
	}
	$return .= '"';

	$return .= isset($list['class']) ? ' class="'.$list['class'].'"' : ' class="campo"';

	$return .= isset($list['style']) ? ' style="'.$list['style'].'"' : '';

	$return .= isset($list['minlength']) ? ' minlength="'.$list['minlength'].'"' : '';
	$return .= isset($list['maxlength']) ? ' maxlength="'.$list['maxlength'].'"' : '';
	$return .= isset($list['min']) ? ' min="'.$list['min'].'"' : '';
	$return .= isset($list['max']) ? ' max="'.$list['max'].'"' : '';

	$return .= ' placeholder="';
	$return .= isset($list['placeholder']) ? $list['placeholder'] : '';
	$return .= '"';
	
	$return .= isset($list['title']) ? ' title="'.$list['title'].'"' : '';

	$return .= isset($list['accept']) ? ' accept="'.$list['accept'].'"' : '';

	$return .= isset($list['required']) ? ' required' : '';
	#TODO
	$return .= '>';
	$return .= isset($list['label']) && $list['label'] ? '</label>' : '';
	return $return;
}

function pSelect($list){
	$return = exLabel($list);

	$return .= '<select ';

	$return .= 'name="'. (isset($list['name']) ? $list['name'] : '') . '"';
	$return .= isset($list['style']) ? ' style="'.$list['style'].'"' : '';
	$return .= isset($list['required']) ? ' required' : '';
	$return .= '>';
	$return .= '<option value="" class="optg">'. (isset($list['texto']) ? str_replace(':','',$list['texto']) : 'Archivo') . '</option>';
	if(isset($list['option'])){
		foreach ($list['option'] as $key => $value) {
			$return .= '<option';
			$return .= is_string($key) ? ' value="'.$key.'"' : '';
			if(isset($_SESSION['tmpForm']) && !isset($list['des_session']) or isset($_SESSION['tmpForm']) && isset($list['des_session']) && !$list['des_session']){
				foreach ($_SESSION['tmpForm'] as $key2 => $value2) {
					if($key2 == $list['name']){
						if($value2 == $value){
							$return .= ' selected';
							break;
						} elseif($value2 == $key){
							$return .= ' selected';
							break;
						} elseif($value2 == $key2){
							$return .= ' selected';
							break;
						}
					}
				}
			} else {
				$return .= isset($list['value']) && $list['value'] == $value ? ' selected' : '';
				$return .= isset($list['value']) && $list['value'] == $key ? ' selected' : '';
			}
			$return .= '>'.$value.'</option>';
		}
	}
	$return .= '</select>';
	$return .= isset($list['label']) && $list['label'] ? '</label>' : '';
	return $return;
}

function pSelectArchivos($list){
	$return = exLabel($list);
	$return .= '<select ';

	$return .= 'name="'. (isset($list['name']) ? $list['name'] : '') . '"';
	$return .= isset($list['style']) ? ' style="'.$list['style'].'"' : ' style="max-width: 170px;"';
	$return .= '>';
	$return .= '<option value="" class="optg">'. (isset($list['texto']) ? str_replace(':','',$list['texto']) : 'Archivo') . '</option>';
	$ruta_archivos = $list['ruta'];
	$archivos = glob($ruta_archivos.'*.{'.(isset($list['tipo_archivos']) ? $list['tipo_archivos'] : '.php').'}', GLOB_BRACE);
	sort($archivos, SORT_NATURAL | SORT_FLAG_CASE);
	$continua = true;
	foreach ($archivos as $key => $value) {
		if (isset($list['referencia'])){ $continua = false;
			$file_convertido = substr($value, strlen($list['ruta']));
			$file_convertido = explode('-', $file_convertido);
			if (in_array($file_convertido[0], $list['referencia'])) { $continua = true; }
		}
		if ($continua) {
			$return .= '<option value="';

			if(!isset($list['value-devuelve']) or isset($list['value-devuelve']) && !$list['value-devuelve']){
				$return .= str_replace('../', '', $value);
			} else {
				if($list['value-devuelve'] == 'basename'){
					$return .= basename($value);
				} elseif($list['value-devuelve'] == 'dirname'){
					$return .= dirname($value);
				} else {
					$return .= 'value-devuelve esta indefinido';
				}
			}

			$return .= '"';
			if(isset($_SESSION['tmpForm']) && !isset($list['des_session']) or isset($_SESSION['tmpForm']) && isset($list['des_session']) && !$list['des_session']){
				foreach ($_SESSION['tmpForm'] as $key2 => $value2) {
					if($key2 == $list['name']){
						if($value2 == (str_replace('../', '', isset($list['value-devuelve']) ? (
							$list['value-devuelve'] == 'basename' ? basename($value) : dirname($value)
						) : $value))){
							$return .= ' selected';
							break;
						}
					}
				}
			} else {
				if(!isset($list['value-devuelve']) or isset($list['value-devuelve']) && !$list['value-devuelve']){
					$return .= isset($list['value']) && $list['value'] == (str_replace('../', '', $value)) ? ' selected' : '';
				} else {
					if($list['value-devuelve']=='basename'){
						$return .= isset($list['value']) && $list['value'] == (str_replace('../', '', basename($value))) ? ' selected' : '';
					} elseif($list['value-devuelve']=='dirname'){
						$return .= isset($list['value']) && $list['value'] == (str_replace('../', '', dirname($value))) ? ' selected' : '';
					} else {
						$return .= 'value-devuelve esta indefinido';
					}
				}
			}
			$return .= '>'.basename($value).'</option>';
		}
	}
	$return .= '</select>';
	return $return;
}


function pSelectArchivosTitulo($list){
	$return = exLabel($list);

	$return .= '<select ';

	$return .= 'name="'. (isset($list['name']) ? $list['name'] : '') . '"';
	$return .= isset($list['style']) ? ' style="'.$list['style'].'"' : ' style="max-width:170px;"';
	$return .= '>';
	$return .= '<option value="" class="optg">'. (isset($list['texto']) ? str_replace(':','',$list['texto']) : 'Archivo') . '</option>';
	$ruta_archivos = $list['ruta'];
	$archivos = glob($ruta_archivos.'*.{'.(isset($list['tipo_archivos'])?$list['tipo_archivos']:'.php').'}', GLOB_BRACE);
	foreach ($archivos as $key => $value) {

		$return .= '<option value="';

		if(!isset($list['value-devuelve']) or isset($list['value-devuelve']) && !$list['value-devuelve']){
			$return .= str_replace('../', '', $value);
		} else {
			if($list['value-devuelve']=='basename'){
				$return .= basename($value);
			} elseif($list['value-devuelve']=='dirname'){
				$return .= dirname($value);
			} else {
				$return .= 'value-devuelve esta indefinido';
			}
		}

		$return .= '"';
		if(isset($_SESSION['tmpForm']) && !isset($list['des_session']) or isset($_SESSION['tmpForm']) && isset($list['des_session']) && !$list['des_session']){
			foreach ($_SESSION['tmpForm'] as $key2 => $value2) {
				if($key2==$list['name']){
					if($value2==basename($value)){
						$return .= ' selected';
					}
					break;
				}
			}
		} else {
			$return .= isset($list['value']) && $list['value'] == (str_replace('../', '', $value)) ? ' selected' : '';
		}
		require $value;
		$return .= '>'.$AC['titulo'].'</option>';
	}
	unset($ACR); unset($AC);
	$return .= '</select>';
	return $return;
}

function pTextarea($list){
	$return = exLabel($list);

	$return .= '<textarea ';
	$return .= 'name="'.(isset($list['name']) ? $list['name'] : '').'"';
	$return .= isset($list['style']) ? 'style="'.$list['style'].'"' : '';
	$return .= isset($list['placeholder']) ? ' placeholder="'.$list['placeholder'].'"' : '';
	$return .= ' class="'.(isset($list['class']) ? $list['class'] : '').'"';

	$return .= isset($list['minlength']) ? ' minlength="'.$list['minlength'].'"' : '';
	$return .= isset($list['maxlength']) ? ' maxlength="'.$list['maxlength'].'"' : '';

	$return .= isset($list['title']) ? ' title="'.$list['title'].'"' : '';

	$return .= isset($list['required']) && $list['required'] ? ' required' : '';

	$return .='>';
	if(isset($_SESSION['tmpForm']) && !isset($list['des_session']) or isset($_SESSION['tmpForm']) && isset($list['des_session']) && !$list['des_session']){
		foreach ($_SESSION['tmpForm'] as $key => $value) {
			if($key==$list['name']){
				$return .= $value;
				break;
			}
		}
	} else {
		$return .= isset($list['value']) ? $list['value'] : '';
	}
	$return .= '</textarea>';
	return $return;
}

function pEnlace($list){
	$return = '<a';
	$return .= isset($list['class']) ? ' class="'.$list['class'].'"' : ' class="boton"';
	$return .= isset($list['style']) ? ' style="'.$list['style'].'"' : '';
	$return .= isset($list['href']) ? ' href="'.$list['href'].'"' : '';
	$return .= isset($list['target']) ? ' target="'.$list['target'].'"' : '';
	$return .= '>';
	$return .= isset($list['texto']) ? $list['texto'] : '';
	$return .= isset($list['icono']) ? ' <i class="'.$list['icono'].'"></i>' : '';
	$return .= '</a>';
	return $return;
}

function pCheckboxBoton($list){
	$list['name'] = $list['name'] ?? ($list['nameidclass'] ?? '');
	$list['id'] = $list['id'] ?? ($list['nameidclass'] ?? 'input-check');
	if(isset($_SESSION['tmpForm']) && !isset($list['des_session']) or isset($_SESSION['tmpForm']) && isset($list['des_session']) && !$list['des_session']){
		foreach ($_SESSION['tmpForm'] as $key => $value) {
			if($key == $list['name']){
				$list['checked'] = !empty($value) ? 'checked' : '';
				break;
			}
		}
	} else {
		if(isset($list['checked'])){
			if($list['checked'] === true){
				$list['checked'] = !empty($list['checked']) ? 'checked' : '';
			}
			if($list['checked'] !== true && $list['checked'] !== false){
				$list['checked'] = $list['checked'] != '' ? ' '.$list['checked'] : '';
			}
		}
	}
	$return = "<input id='{$list['id']}' class='".($list['class'] ?? 'input-check')."' name='{$list['name']}' type='checkbox' ".(isset($list['required']) && !empty($list['required']) ? 'required' : '') . ($list['checked'] ?? ''). ' hidden>';
	$return .= "<label for='{$list['id']}' class='check-boton'>";
	$return .= '<span class="' .($list['class'] ?? 'boton-check boton-mini'). '" '. (isset($list['title']) && !empty($list['title']) ? 'title="'.$list['title'].'"' : ''). '>' .($list['texto'] ?? '') . (isset($list['icono']) && !empty($list['icono']) ? ' <i class="' . $list['icono'] . '"></i>' : '').'</span>';
	$return .= '</label>';
	return $return;
}

function pCheckboxBotonActivoDesaptivo($Web, $Apartado, $list){
	$list['activo'] = $list['activo'] ?? '<i class="fas fa-eye"></i>';
	$list['default'] = $list['default'] ?? '<i class="fas fa-eye-slash"></i>';
	if (isset($list['invertir']) && $list['invertir']) {
		$save = [$list['activo'], $list['default']];
		$list['activo'] = $save[1];
		$list['default'] = $save[0];
	}
	$list['texto'] = $list['texto'] ?? ($list['texto2'] ?? '');
	$list['name'] = $list['name'] ?? $list['nameidclass'];

	if(isset($list['texto2']) && !empty($list['texto2']) || isset($list['texto-2']) && !empty($list['texto-2'])){
		$list['activo'] = ''; $list['default'] = '';
		$list['texto'] = $list['texto2'] ?? $list['texto-2'];
	}
	if (is_string($Apartado)) {
		if (isset($Web[$Apartado])) { $Carga = $Web[$Apartado]; }
	} else {
		if (isset($Web[$Apartado[0]][$Apartado[1]])) { $Carga = $Web[$Apartado[0]][$Apartado[1]]; }
	}

	return pCheckboxBoton([
		'texto'=> (
			isset($Carga[$list['name']]) && !empty($Carga[$list['name']]) ?
				$list['activo'] : $list['default']
			).
			($list['texto'] ?? ''),
		'name' => $list['name'] ?? $list['name'],
		'id' => $list['id'] ?? $list['name'],
		'title' => ($list['title'] ?? ''),
		'icono' => ($list['icono'] ?? ''),
		'checked' => (isset($Carga[$list['name']]) && $Carga[$list['name']] != '' ? true : false)
	]);
}

# Plantilla

function ExtructuraEnlace () {
	return [
		'select' => [
			['name'=>'icono_posicion','texto'=>'P. Icono','title'=>'Posición del icono.', 'class' => 'form-campo-pequeno']
		],
		'input' => [
			['name'=>'icono','texto'=>'Icono','placeholder'=>'fas fa-inicio','title'=>'Icono.'],
			['name'=>'texto','texto'=>'Texto','placeholder'=>'Inicio','title'=>'Texto.'],
			['name'=>'url','texto'=>'Enlace','placeholder'=>'blogs / https','title'=>'Directorio local u enlace externo.'],
			['name'=>'class','texto'=>'Class','placeholder'=>'Class','title'=>'Class.']
		],
		'checkbox' => [
			['name'=>'http','texto'=>'Http','title'=>'Enlace URL HTTP/S.'],
			['name'=>'externo','texto'=>'Externo','title'=>'Abrir el enlace en una nueva pestaña.'],
			['name'=>'ocultar','texto'=>'<i class="fas fa-eye-slash"></i>','title'=>'Ocultar.'],
		]
	];
}

function pInputEnlace($Web, $Apartado, $list = [], $Contenedor = null, $Elemento = null){ global $Web;
	$lista = ExtructuraEnlace();
	
	$Carga = is_string($Apartado) ? ($Web[$Apartado] ?? '') : ($Web[$Apartado[0]][$Apartado[1]] ?? '');
	$return = '<details><summary>Enlaces</summary>';
	$return .= '<section style="display: flex; flex-wrap: wrap; gap: 4px; flex-direction: column;">';
	$return .= '<section class="flex-between">';
	$return .= pInput([
		'placeholder' => 1,
		'type'=>'number',
		'class'=>'form-campo-pequeno',
		'title' => 'Cantidad de enlaces.',
		'name' => (isset($list['name']) ? $list['name'].'_' : '')."cantidad_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}",
		'label' => true, 'texto' => 'Cantidad',
		'value' => (isset($Carga[(isset($list['name']) ? $list['name'].'_' : '')."cantidad_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}"]) ?
			trim(htmlspecialchars($Carga[(isset($list['name']) ? $list['name'].'_' : '')."cantidad_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}"]))
			: '')
		]);
	$return .= pCheckboxBotonActivoDesaptivo($Web, $Apartado, [
		'name' => (isset($list['name']) ? $list['name'].'_' : '')."mostrar_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}",
		'title' => 'Mostrar / Ocultar.'
		]);
	$return .= '</section>';
	if(!empty($Carga) && isset($Carga[(isset($list['name']) ? $list['name'].'_' : '')."cantidad_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}"])){
		for ($i = 1; $i <= $Carga[(isset($list['name']) ? $list['name'].'_' : '')."cantidad_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}"]; $i++) {
			$return .= '<section>';
			foreach ($lista['input'] as $value) {
				$return .= pInput([
					'placeholder' => $value['placeholder'],
					'title' => $value['title'],
					'class' => $value['class'] ?? '',
					'name' => (isset($list['name']) ? $list['name'].'_' : '')."{$value['name']}_{$i}_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}",
					'label' => false, 'texto' => $value['texto'],
					'value' => (isset($Carga[(isset($list['name']) ? $list['name'].'_' : '')."{$value['name']}_{$i}_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}"]) ?
						trim(htmlspecialchars($Carga[(isset($list['name']) ? $list['name'].'_' : '')."{$value['name']}_{$i}_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}"]))
						: '')
					]).' ';
			}
			$return .= '<details><summary><small>Extras</small></summary><section>';
			foreach ($lista['select'] as $value) {
				$return .= pSelect([
					'title' => $value['title'],
					'class' => $value['class'] ?? '',
					'name' => (isset($list['name']) ? $list['name'].'_' : '')."{$value['name']}_{$i}_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}",
					'label' => false, 'texto' => $value['texto'],
					'option' => ['izquierda'=>'Izquierda', 'derecha' => 'Derecha'],
					'value' => $Carga[(isset($list['name']) ? $list['name'].'_' : '')."{$value['name']}_{$i}_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}"] ?? '',
					]).' ';
			}
			foreach ($lista['checkbox'] as $value) {
				$return .= $value['name'] != 'ocultar' ? (pCheckboxBotonActivoDesaptivo($Web, ['plantilla', 'scr'], [
					'nameidclass'=>(isset($list['name']) ? $list['name'].'_' : '')."{$value['name']}_{$i}_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}",
					'texto-2'=>$value['texto'],
					'title'=>$value['title']
				])) : (pCheckboxBotonActivoDesaptivo($Web, ['plantilla', 'scr'], [
					'nameidclass'=>(isset($list['name']) ? $list['name'].'_' : '')."{$value['name']}_{$i}_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}",
					'title'=>$value['title'],
					'invertir' => true
				]));
			}
			$return .= '</section></details>';
			$return .= '</section>';
		}
	}
	$return .= '</details>';
	return $return;
}


function EnlaceExtructura($Web, $Apartado, $list = [], $Contenedor = null, $Elemento = null){ global $Web;
	$lista = ExtructuraEnlace();
	
	$Carga = is_string($Apartado) ? ($Web[$Apartado] ?? '') : ($Web[$Apartado[0]][$Apartado[1]] ?? '');
	$return = '';
	if(!empty($Carga) && isset($Carga[(isset($list['name']) ? $list['name'].'_' : '')."cantidad_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}"]) && isset($Carga[(isset($list['name']) ? $list['name'].'_' : '')."mostrar_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}"]) && !empty($Carga[(isset($list['name']) ? $list['name'].'_' : '')."mostrar_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}"])){
		for ($i = 1; $i <= $Carga[(isset($list['name']) ? $list['name'].'_' : '')."cantidad_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}"]; $i++) {
			$name = "_{$i}_enlace_comandos_default_elemento_{$Elemento}_contenedor_{$Contenedor}";
			$mostrar = true;
			if (
				isset($Carga[(isset($list['name']) ? $list['name'].'_' : '').'ocultar'.$name]) &&
				$Carga[(isset($list['name']) ? $list['name'].'_' : '').'ocultar'.$name] != '') {
				$mostrar = false;
			}
			if ($mostrar) {
			$return .= '<a ';
			$lista = [
					'class' => ['class="', '" '],
					'url' => [
						'href="' .
						(
							!isset($Carga[(isset($list['name']) ? $list['name'].'_' : '').'http'.$name]) ||
							isset($Carga[(isset($list['name']) ? $list['name'].'_' : '').'http'.$name]) &&
							empty($Carga[(isset($list['name']) ? $list['name'].'_' : '').'http'.$name]) ?
							$Web['directorio']
							: ''
						), '" '],
					'externo' => 'target="_blank"',
					'icono' => ['<i class="', '"></i> '],
					'texto' => ''
			];
			if (
				isset($Carga[(isset($list['name']) ? $list['name'].'_' : '').'icono_posicion'.$name]) &&
				$Carga[(isset($list['name']) ? $list['name'].'_' : '').'icono_posicion'.$name] == 'derecha') {
				unset($lista['icono']);
				$lista['icono'] = [' <i class="', '"></i>'];
			}
			if (isset($list['solo']) && !empty($list['solo'])) {
				if($list['solo'] == 'icono') { unset($lista['texto']); }
				if($list['solo'] == 'texto') { unset($lista['icono']); }
			}
			foreach ($lista as $key => $value) {	
					$return .= isset($Carga[(isset($list['name']) ? $list['name'].'_' : '').$key.$name]) && !empty($Carga[(isset($list['name']) ? $list['name'].'_' : '').$key.$name]) ?
					(
						is_string($value) ?
							(!empty($value) ? $value : $Carga[(isset($list['name']) ? $list['name'].'_' : '').$key.$name])
						: $value[0] . $Carga[(isset($list['name']) ? $list['name'].'_' : '').$key.$name] . $value[1]
					) : (
						$key == 'url' ? 'href="'.$Web['directorio'].'" ' : ''
					);
				$return .= $key == 'externo' ? '>' : '';
			}
			$return .= '</a>';
			}
		}
	}
	$return .= '</section>';
	return PlantillaComandos($return, $Contenedor, $Elemento);
}

?>