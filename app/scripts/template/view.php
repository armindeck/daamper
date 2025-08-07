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

require __DIR__.'/scripts.php';
