<?php

/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  normal-view.php                                                       */
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

$return .= $fields["title"] . $fields["description"] .
	$fields["meta_description"] . $fields["catalog"] .
	$fields["meta_tags"] . $fields["fragment"] .
	$commands_view . "<small>" . Language("markdown-is-supported") . "</small>" . $fields["content"];

$return .= pSelect(['name' => 'tipo', 'texto' => Language('type'), 'title' => Language('type'), 'option' => [
	'normal' => Language('normal'),
	'blog' => Language('blog'),
	'normal-blog' => Language(['creator', 'blog-and-thumbnail'], 'dashboard'),
	'libre' => Language('free'),
]]);

/* ------------ List of entries ------------- */
if (isset($_SESSION['tmpForm']["archivo"]) && $_SESSION['tmpForm']["archivo"] == 'index.php'){
	$list_of_entries_text = Language(['creator', 'list-of-entries'], 'dashboard');

	$p = file_exists(RAIZ . "database/creator/list-of-entries.json") ? Daamper::$data->Read("creator/list-of-entries") : [];
	$j = 1;
	$inputs_lists_of_entries = "";
	foreach ($p as $key => $value) {
		$inputs_lists_of_entries .= '<section class="flex-column"><label class="flex-between"><span>' . ($value['entrada'] ? ucfirst($value['entrada']) : Language(['creator', 'posts'], 'dashboard')) . '</span><section class="flex-between">';
		$inputs_lists_of_entries .= pInput(['type' => 'number', 'class' => 'form-campo-pequeno', 'title' => Language('position'), 'name' => "posicion-{$value['entrada']}", 'value' => $j, 'placeholder' => $j]);
		$inputs_lists_of_entries .= pCheckboxBoton(['name' => "mostrar-{$value['entrada']}", 'id' => "mostrar-{$value['entrada']}", 'icono' => 'fas fa-eye']);
		$inputs_lists_of_entries .= '</section></label></section>';
		$j++;
	}

	$return .= <<<HTML
	<details class="sub_container">
		<summary>$list_of_entries_text</summary>
		<section class="flex flex-column gap-4">
			$inputs_lists_of_entries
		</section>
	</details>
	HTML;
}
/* ------------ End list of entries ------------- */

// Container thumbnail and options
$return .= "<div class=\"sub_container\">";
$return .= "<details><summary>" . Language("thumbnail-options") . "</summary><section class=\"flex flex-column gap-4\">";
$return .= $fields["link_upload_image"] . $fields["thumbnail_select"] . $fields["thumbnail_url"];
$return .= "</section></details></div>";

$return .= "<hr><div class=\"flex gap-4\">";
$return .= $fields["ads_checkbox"] . $fields["private_checbox"] .
	$fields["comment_checkbox"] . $fields["comments_checkbox"] .
	$fields["show_in_index_checkbox"];
$return .= "</div><hr>";

$return .= $fields["folder"] . $fields["file"];
