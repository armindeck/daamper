<?php

/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  Template.php                                                          */
/**************************************************************************/
/*                        This file is part of:                           */
/*                              daamper                                   */
/*                 https://github.com/armindeck/daamper                   */
/**************************************************************************/
/* Copyright (c) 2025 DBHS / daamper                                      */
/*                                                                        */
/* Se concede permiso, de forma gratuita, a cualquier persona para usar,  */
/* modificar y ejecutar el código fuente de este software, incluyendo su  */
/* uso en proyectos comerciales (como monetización por publicidad o       */
/* donaciones).                                                           */
/*                                                                        */
/* Restricciones estrictas:                                               */
/* - No está permitido vender, sublicenciar o distribuir el código        */
/*   fuente —total o parcialmente— con fines de lucro.                    */
/* - No está permitido convertir el código en privativo ni eliminar       */
/*   esta licencia.                                                       */
/* - No está permitido reclamar la autoría del código original.           */
/*                                                                        */
/* Uso permitido:                                                         */
/* - Se permite modificar y usar el código con fines personales,          */
/*   educativos y/o comerciales, siempre que no se venda.                 */
/* - Se permite usar este software como base para otros proyectos,        */
/*   siempre que esta licencia se mantenga.                               */
/*                                                                        */
/* El autor (DBHS / daamper) se reserva el derecho de modificar esta      */
/* licencia en futuras versiones del software.                            */
/*                                                                        */
/* EL SOFTWARE SE ENTREGA "TAL CUAL", SIN GARANTÍAS DE NINGÚN TIPO,       */
/* EXPRESAS O IMPLÍCITAS, INCLUYENDO, SIN LIMITACIÓN, GARANTÍAS DE        */
/* COMERCIABILIDAD, IDONEIDAD PARA UN PROPÓSITO PARTICULAR Y NO           */
/* INFRACCIÓN. EN NINGÚN CASO LOS AUTORES SERÁN RESPONSABLES POR          */
/* RECLAMACIONES, DAÑOS U OTRAS RESPONSABILIDADES, YA SEA EN UNA ACCIÓN   */
/* CONTRACTUAL, EXTRACONTRACTUAL O DE OTRO TIPO, DERIVADAS DE O EN        */
/* CONEXIÓN CON EL SOFTWARE, SU USO O OTRO TIPO DE MANEJO.                */
/**************************************************************************/
use Core\Render;

class Template extends Local {
	public function __construct(
		private array $template = [],
		private array $core = []
	){}
		
	private function getCommands(){ return Local::read("config/template-commands") ?? []; }
	public function render(string $section = "", bool $show_view = false): void {
		$template = $this->template;

		// Encontrar el contenedor main
		if(!empty($template["cantidad_contenedores"])){
			for ($i = 1; $i <= ($template["cantidad_contenedores"] ?? 1); $i++){
				if (!empty($template["tipo_contenedor_{$i}"]) && $template["tipo_contenedor_{$i}"] == "main") {
					$main_encontrado = true;
				}
			}
		}

		// Si no se encuentra el contenedor main, mostrara la vista main
		if (empty($template["cantidad_contenedores"]) || isset($_GET["view"]) || !isset($main_encontrado)) {
			Daamper::views("main"); return;
		}

		// Cargar todo el contenido
		for ($i = 1; $i <= ($template["cantidad_contenedores"] ?? 0); $i++){
			if (empty($section)) {
				$this->content($show_view, $i, $section);
			} else {
				if (!empty($template["tipo_contenedor_{$i}"]) && $template["tipo_contenedor_{$i}"] == $section) {
					$this->content($show_view, $i, $section);
					return;
				}
			}
		}
	}

	private function content(bool $show_view = false, int $parent, string $section = ""): void {
		$template = $this->template;
		if(!empty($template["tipo_contenedor_{$parent}"]) && $template["tipo_contenedor_{$parent}"] == "main" && empty($template["mostrar_contenedor_{$parent}"])){
			$template["mostrar_contenedor_{$parent}"] = "on";
		}

		if (!empty($template["mostrar_contenedor_{$parent}"])){
			
			// Mostrar contenedor de apertura
			echo !empty($template["div_abrir_contenedor_{$parent}"]) ? $this->commands($template["div_abrir_contenedor_{$parent}"], $parent) : "";
			
			// Mostrar contenedor con elementos
			if (!empty($template["tipo_contenedor_{$parent}"]) && $template["tipo_contenedor_{$parent}"] == "main") {
				Daamper::views("main");
			} elseif (!empty($section)) {
				if(!empty($template["tipo_contenedor_{$parent}"]) && $template["tipo_contenedor_{$parent}"] == $section){
					if ($show_view){ Daamper::views($template["tipo_contenedor_{$parent}"]); } else {
						$this->elements($parent);
					}
				}
			} else {
				if ($show_view){ Daamper::views($template["tipo_contenedor_{$parent}"]); } else {
					$this->elements($parent);
				}
			}

			// Mostrar contenedor de cierre
			echo !empty($template["div_cerrar_contenedor_{$parent}"]) ? $this->commands($template["div_cerrar_contenedor_{$parent}"], $parent) : "";
		}
	}

	private function elements(int $parent): void {
		$template = $this->template;
		if(!empty($template["cantidad_elementos_contenedor_{$parent}"])) {
			for($i = 1; $i <= $template["cantidad_elementos_contenedor_{$parent}"]; $i++){
				if(!empty($template["mostrar_elemento_{$i}_contenedor_{$parent}"])) {
					
					// Mostrar estilos css
					echo !empty($template["estilos_campos_default_elemento_{$i}_contenedor_{$parent}"]) ?
						"<style type=\"text/css\">\n{$template["estilos_campos_default_elemento_{$i}_contenedor_{$parent}"]}\n</style>" : "";
					
					// Abrir etiqueta, por defecto <div>
					echo !empty($template["div_abrir_campos_default_elemento_{$i}_contenedor_{$parent}"]) &&
						empty($template["ocultar_etiquetas_contenedor_campos_default_elemento_{$i}_contenedor_{$parent}"]) ?
							$this->commands($template["div_abrir_campos_default_elemento_{$i}_contenedor_{$parent}"], $parent, $i)
						: (empty($template["ocultar_etiquetas_contenedor_campos_default_elemento_{$i}_contenedor_{$parent}"]) ?
							"<div>" : "");

					// Mostrar titulo y contenido
					foreach (["titulo", "contenido"] as $key => $value) {
						if(!empty($template["{$value}_campos_default_elemento_{$i}_contenedor_{$parent}"])){
							echo $value == "titulo" ? "<strong>" : "";
							echo $this->commands(
								$value == "titulo" ? (
									Language(
										str_replace(
											[" ", "_"],
											"-",
											strtolower(
												$template["{$value}_campos_default_elemento_{$i}_contenedor_{$parent}"]
											)
										)
									) ??
									$template["{$value}_campos_default_elemento_{$i}_contenedor_{$parent}"]
								) : $template["{$value}_campos_default_elemento_{$i}_contenedor_{$parent}"],
								$parent, $i);
							echo $value == "titulo" ? "</strong><hr>" : "";
						}
					}

					// Cerrar etiqueta, por defecto </div>
					echo !empty($template["div_cerrar_campos_default_elemento_{$i}_contenedor_{$parent}"]) &&
						empty($template["ocultar_etiquetas_contenedor_campos_default_elemento_{$i}_contenedor_{$parent}"]) ?
							$this->commands($template["div_cerrar_campos_default_elemento_{$i}_contenedor_{$parent}"], $parent, $i)
						: (empty($template["ocultar_etiquetas_contenedor_campos_default_elemento_{$i}_contenedor_{$parent}"]) ?
							"</div>" : "");
				}
			}
		}
	}

	public function commands(string $string, $contenedor, $elemento = 1, $render = new Render): string {
		$patron = '/\[(Form|View|Return)=([^>]+)(?:\s+(name|placeholder|required|value|type)="([^"]+)")*\]/';
	
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
				#echo !empty($comando_elementos) ? "<font color='orangered'>$comando_elementos</font><br>" : "";
			
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
			
			$datos = str_ireplace("[$comando=$comando_valor". (!empty($comando_elementos) ? ' '.$comando_elementos : ""). "]", $this->commandsReplace($comando, $comando_valor, $comando_atributos, $contenedor, $elemento, $render), $datos);
		}
		
		return !empty($datos) ? $datos : $string;
	}

	private function commandsReplace(string $comando, string $comando_valor, array|string $comando_atributos, int $contenedor, int $elemento, $render): string {
		$commands = $this->getCommands();
		$Core = $this->core;

		$search = !empty($commands[$comando][$comando_valor]) ? $commands[$comando][$comando_valor] : "";
		$type = !empty($search) ? explode(".", $search) : "";
		$valor = !empty($type[1]) && is_string($type[1]) ? $type[1] : $search;

		if(is_array($type) && in_array($type[0], ["form", "link"])){
			if (in_array($valor, ["input"])) {
				$comando_atributos["name"] = ($comando_atributos["name"] ?? "empty") . "_elemento_{$elemento}_contenedor_{$contenedor}";
			}
			
			if (in_array($valor, ["link", "input_modal", "input_modal_quantity", "link_new"])) {
				$comando_atributos["name"] = $comando_atributos["name"] ?? "empty";
			}

			if (in_array($valor, ["input", "link"])) {
				$comando_atributos["value"] = $Core["template"]["scr"][$comando_atributos["name"]] ?? "";
			}
		}

		$copy = function($config) {
			$anio_published = !empty($config['ano_publicada']) && $config['ano_publicada'] != date("Y") ?
					$config['ano_publicada'] . ' -' : "";

			return "&copy; {$anio_published} ". date("Y") . ' ' . ($config['nombre_web'] ?? "") . '.';
		};

		$iframe = function ($directorio, $comando_atributos) {
			$comando_atributos['get'] = isset($comando_atributos['get']) ? '?' . str_replace('~', '=', $comando_atributos['get']) : '';
				if (substr($comando_atributos['src'], 0, 4) != 'http') {
					$comando_atributos['src'] = $directorio . $comando_atributos['src'];
					if (!file_exists($comando_atributos['src'])) { return ""; }
				}
				return '<iframe style="width: 100%; height: '.($comando_atributos['height'] ?? '100%').';" src="'.$comando_atributos['src'].$comando_atributos['get'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
		};

		if ($comando == 'View') {
			if (file_exists($Core["directorio"] . Daamper::viewsPath($comando_valor))) {
				Daamper::views($comando_valor);
			} else {
				return "no se encontro la vista <strong>$comando_valor</strong>.";
			}
			return "<i hidden></i>";
		}

		if(is_array($type) && $type[0] == "link"){
			if($valor == "link" || $valor == "session" || $valor == "non_session" || $valor == "non_dashboard"){
				$link_extruct = EnlaceExtructura($Core, ["template","scr"], ["name" => $comando_atributos["name"] ?? "", 'solo' => $comando_atributos['solo'] ?? "", 'class' => $comando_atributos['class'] ?? ""], isset($comando_atributos['contenedor']) ? $comando_atributos['contenedor'] : $contenedor, isset($comando_atributos['elemento']) ? $comando_atributos['elemento'] : $elemento);
			}
			if($valor == "link_new" || $valor == "link_new_session" || $valor == "link_new_non_session" || $valor == "link_new_non_dashboard"){
				$link_new = $render->linkRenderSearchAutomatic($comando_atributos["name"] ?? "", $Core["template"]["scr"] ?? [], ["container" => $comando_atributos['contenedor'] ?? $contenedor, "element" => $comando_atributos['elemento'] ?? $elemento, "Template" => $this, "directory" => $Core["directorio"], "unique" => $comando_atributos['unique'] ?? ""]);
			}
			if($valor == "link_new_all" || $valor == "link_new_all_session" || $valor == "link_new_all_non_session" || $valor == "link_new_all_non_dashboard"){
				$link_new_all = $render->linkRenderSearchAutomaticAll($comando_atributos["name"] ?? "", $Core["template"]["scr"] ?? [], ["container" => $comando_atributos['contenedor'] ?? $contenedor, "element" => $comando_atributos['elemento'] ?? $elemento, "Template" => $this, "directory" => $Core["directorio"], "unique" => $comando_atributos['unique'] ?? ""]);
			}
		}

		if(is_array($type) && $type[0] == "form"){
			if($valor == "input_modal"){
				$render_modalInputLinkSearchAutomatic = $render->modalInputLinkSearchAutomatic(null, $comando_atributos["name"] ?? "", $Core["template"]["scr"] ?? [], ["container" => $contenedor, "element" => $elemento]);
			}
			if($valor == "input_modal_quantity"){
				$render_input_model_quantity = $render->modalInputLinkSearchAutomaticQuantity(null, $comando_atributos["name"] ?? "", $Core["template"]["scr"] ?? [], ["container" => $contenedor, "element" => $elemento]);
			}
		}


		$noencontro = fn($comando) => "No se encontro el comando <strong>{$comando}</strong>.";
		
		return is_array($type) ? match ($type[0]) {
			"info"   => match ($valor) {
				"copyright_clasic"	=> Daamper::$projectInfo->render(),
				"developed_by"		=> Daamper::$projectInfo->developedBy(),
				default				=> Daamper::$projectInfo->$valor ?? $noencontro($search)
			},
			"config" 				=> $Core["config"][$valor] ?? $noencontro($search),
			"other"					=> match ($valor) {
				"copy"				=> $copy($Core["config"]),
				"directory"			=> $Core["directorio"],
				"base_image"		=> "assets/img/",
				"directory_and_base_image"		=> $Core["directorio"] . "assets/img/",
				"visits"			=> Local::read("other/visits")["total"] ?? 0,
				"element_content"	=> "_elemento_{$elemento}_contenedor_{$contenedor}" ?? "",
				default				=> $noencontro($search)
			},
			"iframe" => match ($valor) {
				"iframe"			=> $iframe($Core["directorio"], $comando_atributos),
				"dbproject_pages_version" => '<iframe frameborder="0" width="100%" style="min-height: 250px;" src="https://dbproject.rf.gd/main_external.php?tema='.($_SESSION['tmp']['color'] ?? $Core["config"]["color"] ?? 'light').'&cantidad=7&background=none&contenido=daamper-actualizaciones&font-size=14px&max-width=100%"></iframe>',
				default				=> $noencontro($search),
			},
			"link" => match ($valor) {
				"link"				=> $link_extruct ?? "",
				"session"			=> !empty($_SESSION["id"]) ? ($link_extruct ?? "") : "",
				"non_session"		=> empty($_SESSION["id"]) ? ($link_extruct ?? "") : "",
				"non_dashboard"		=> $Core['ruta_completa'] != '../admin/admin.php' ? ($link_extruct ?? "") : "",
				"link_new"			=> $link_new ?? "",
				"link_new_session"			=> !empty($_SESSION["id"]) ? ($link_new ?? "") : "",
				"link_new_non_session"		=> empty($_SESSION["id"]) ? ($link_new ?? "") : "",
				"link_new_non_dashboard"	=> $Core['ruta_completa'] != '../admin/admin.php' ? ($link_new ?? "") : "",
				"link_new_all"		=> $link_new_all ?? "",
				"link_new_all_session"			=> !empty($_SESSION["id"]) ? ($link_new_all ?? "") : "",
				"link_new_all_non_session"		=> empty($_SESSION["id"]) ? ($link_new_all ?? "") : "",
				"link_new_all_non_dashboard"	=> $Core['ruta_completa'] != '../admin/admin.php' ? ($link_new_all ?? "") : "",
				default				=> $noencontro($search)
			},
			"form" => match ($valor) {
				"input"				=> pInput($comando_atributos),
				"link"				=> pInputEnlace($Core, ["template","scr"], ["name" => $comando_atributos["name"]], $contenedor, $elemento),
				"input_modal"		=> $render_modalInputLinkSearchAutomatic ?? "",
				"input_modal_quantity"		=>  $render_input_model_quantity ?? "",
				default				=> $noencontro($search)
			},
			default					=> $noencontro($search)
		} : $search;
	}
}