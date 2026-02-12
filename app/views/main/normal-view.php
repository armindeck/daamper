<?php

/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  juego-view.php                                                        */
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

if (!isset($_GET['view']) || isset($_GET['view']) && in_array($_GET['view'], ['main'])):
/* -------------------------------- CONTENIDO ----------------------------------- */

	// Importar contenido
	global $AX, $AXR;
  require_once RAIZ . 'app/scripts/lib/Markdown.php';
  require_once RAIZ . 'app/scripts/lib/MarkdownExtra.php';

  // Contenido y tipo de contenido
  if (!empty($AX['contenido'])) {
    if (isset($AX['tipo'])) {
      if (in_array(strtolower($AX['tipo']), ['blog', 'normal-blog'])) {
				$data = [
					"id_publicador" => $AXR["id_publicador"] ?? "",
					"fecha_publicado" => $AXR["fecha_publicado"] ?? Daamper::$scripts->fecha_hora(),
					"fecha_modificado" => $AXR["fecha_modificado"] ?? "",
					"tipo" => strtolower($AX["tipo"] ?? ""),
					"titulo" => $AX["titulo"] ?? "",
					"contenido" => $AX["contenido"] ?? "",
					"miniatura" => $AX["miniatura"] ?? "",
					"fragmento" => $AX["fragmento"] ?? "",
					"user_data" => !empty($AXR["id_publicador"]) ? (Daamper::$data->UserAll()[$AXR["id_publicador"]] ?? null) : null
				];
				Daamper::view("main/blog", $data);
			} else {
	      echo in_array(strtolower($AX['tipo']), ['', 'normal']) ? '<div class="con">' : '';
        $contenido = Daamper::$scripts->Commands($AX["contenido"]);
        echo Michelf\MarkdownExtra::defaultTransform($contenido);
	      echo in_array(strtolower($AX['tipo']), ['', 'normal']) ? '</div>' : '';
			}
    }
	}
	
	# LISTA DE ENTRADAS
  if ($AX['archivo'] == 'index.php' && file_exists(__DIR__."/../components/list-of-entries-view.php")) {
    require_once __DIR__."/../components/list-of-entries-view.php";
    $lista = file_exists(RAIZ . "database/creator/list-of-entries.json") ? Daamper::$data->Read("creator/list-of-entries") : [];
    $mostrar = [];
    $posicion = [];
    $poster = [];
    foreach ($lista as $key => $value) {
      if (
        isset($AX["mostrar-{$value['entrada']}"]) && !empty($AX["mostrar-{$value['entrada']}"]) &&
        isset($AX["posicion-{$value['entrada']}"]) && !empty($AX["posicion-{$value['entrada']}"])
      ) {
        $mostrar[$AX["posicion-{$value['entrada']}"]] = $value['entrada'];
        $posicion[$value['entrada']] = $AX["posicion-{$value['entrada']}"];
        $poster[$value['entrada']] = $value['poster'] ?? '';
        $titulo[$value['entrada']] = ['titulo' => $value['titulo'] ?? '', 'titulo-alternativo' => $value['titulo-alternativo'] ?? ''];
      }
    }
    if (in_array(trim($AX['ruta'], '/'), $mostrar) || trim($AX['ruta'], '/') == '') {
      for ($j = 1; $j <= count($mostrar); $j++) {
        $continua = false;
        if (empty($AX['ruta'])) {
          $continua = true;
        }
        if (!empty($AX['ruta']) && trim($AX['ruta'], '/') == $mostrar[$j]) {
          $continua = true;
          $ruta = true;
        }
        if ($continua) {
          listaContenido(
            $mostrar[$j],
            (!empty($poster[$mostrar[$j]]) ? 'poster' : 'normal'),
            $mostrar[$j],
            $lista,
            $titulo[$mostrar[$j]],
            $AX['ruta']
          );
          if (isset($ruta)) {
            $continua = false;
            break;
          }
        }
      }
      echo '<div style="margin-bottom: 15px;"></div>';
    }
  } ?>

<?php /* -------------------------------- CONTENIDO ----------------------------------- */ ?>
<?php endif; ?>
<?php FormComentario() ?>