<?php

/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  creator-view.php                                                      */
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

global $Creator;

$ruta = [
	['titulo' => 'publish', 'archivos' => glob(__DIR__ . '/creators/*')],
	['titulo' => 'posts', 'archivos' => glob(RAIZ . "database/post/*.json")],
	['titulo' => 'drafts', 'archivos' => glob(RAIZ . "database/draft/*.json")],
];

$visits = Daamper::$data->Read("other/visits") ?? [];

$list_of_entries = [
	"load" => Daamper::$data->Read("creator/list-of-entries") ?? [],
	"issetGet" => !empty($_GET['cantidad-entradas']),
	"get" => Daamper::$scripts->normalizar2($_GET['cantidad-entradas'] ?? 0)
];
$list_of_entries["quantity"] = $list_of_entries["issetGet"] ? $list_of_entries["get"] : (count($list_of_entries["load"]) > 0 ? count($list_of_entries["load"]) : 1);

$search = function(array $type_and_routes, array $visits): array {
	$search = [];
	foreach ($type_and_routes as $ruta_value) {
		foreach ($ruta_value["archivos"] as $ruta_file_key => $ruta_file_value) {
			$search[$ruta_value["titulo"]][$ruta_file_key]["origin"] = $ruta_file_value;
			$search[$ruta_value["titulo"]][$ruta_file_key]["base"] = basename($ruta_file_value);
			$search[$ruta_value["titulo"]][$ruta_file_key]["base_not_extension"] = str_replace([".json", ".php"], "", basename($ruta_file_value));
			$search[$ruta_value["titulo"]][$ruta_file_key]["base_not_extension_and_view"] = str_replace(["-view.php", ".json", ".php"], "", basename($ruta_file_value));

			// Visits
			if($ruta_value["titulo"] == "posts"){
				$base_not_extension = $search[$ruta_value["titulo"]][$ruta_file_key]["base_not_extension"];
				foreach ($visits as $visits_key => $visits_value) {
					if(str_replace(".php", "", str_replace("/", "-", $visits_key)) == $base_not_extension) {
						$search[$ruta_value["titulo"]][$ruta_file_key]["visits"] = $visits_value;
					}
				}
			}
		}
	}

	return $search;
};

$creator_title = ["anime_entrada", "anime_mirando", "juego", "normal"];
$creator_translate = ["anime_entrada" => "anime-entry", "anime_mirando" => "anime-watching", "juego" => "game", "normal" => "normal"];

$view_creator_entries = function ($quantity, $text_quantity, $text_attention_update) {
    return <<<HTML
        <p class="t-center" style="background-color: red; color: white; font-weight: bold; padding: 2px 6px 2px 6px; margin-bottom: 4px;">$text_attention_update</p>
        <input type="text" name="ap" value="creator" readonly hidden required>
        <label class="flex flex-between gap-4">
            <span>$text_quantity:</span>
            <input class="form-campo-pequeno" placeholder="1" type="number" min="0" max="99" name="cantidad-entradas" value="{$quantity}">
        </label>
    HTML;
};

$view_creator_entries_details = function ($j, $type, $j_entry, $j_title, $j_title_alternative, $title_zero, $title_zero_title, $title_summary, $disabled_input, $disabled_input_select, $is_poster, $title, $games, $thumbnail, $poster, $the_best_games, $title_in_the_entries) {
    return <<<HTML
        <details>
            <summary>$title_summary</summary>
            <section class="flex flex-column gap-2">
                <div class="flex flex-between gap-8">
                    <input $disabled_input class="flex-1" type="text" name="entrada-{$j}" value="{$j_entry}" placeholder="{$title_zero}" title="{$title_zero_title}">
                    <select $disabled_input name="entrada-poster-{$j}" title="{$type}">
                        <option value="" $disabled_input_select>$thumbnail</option>
                        <option value="on" $is_poster>$poster</option>
                    </select>
                </div>
                <section class="flex flex-between flex-column-mobil">
                    <input class="flex-1" type="text" name="entrada-titulo-{$j}" value="{$j_title}" placeholder="{$title}" title="{$games}">
                    <input class="flex-1" type="text" name="entrada-titulo-alternativo-{$j}" value="{$j_title_alternative}" placeholder="{$title_in_the_entries}" title="{$the_best_games}">
                </section>
            </section>
        </details>
    HTML;
};

$view_buttons_section = function ($type, $list) use ($creator_translate): string {
	$return = "";

	foreach ($list as $value) {
		$link = "?ap=creator&creador=";
			// Creator
			$link .= ($type == "publish" ? $value["base_not_extension_and_view"] : "normal");
			// Type
			$link .= ($type != "publish" ? "&tipo=" . ($type == "posts" ? "publicacion" : "borrador") : "");
			// File
			$link .= $type != "publish" ? "&archivo={$value['base']}" : "";

		$label = $type == "publish" ? Language($creator_translate[$value["base_not_extension_and_view"]]) : $value["base_not_extension_and_view"];
		$visit = $value["visits"] ?? 0;
		$visits_span = $type != "publish" && $visit > 0 ? "<small><i class=\"fas fa-eye\"></i> {$visit}</small>" : "";

		$return .= "<a class=\"boton-2 flex flex-between gap-4\" href=\"$link\"><span>{$label}</span>{$visits_span}</a>";
	}

	return $return;
};

// Form entries
$formEntries = function() use ($list_of_entries, $view_creator_entries, $view_creator_entries_details): string {
	$form = "<div class=\"flex flex-column gap-8\">";
	
	$form .= $view_creator_entries($list_of_entries["quantity"], Language("quantity"), Language(['creator', 'attention-update'], 'dashboard'));
	$form .= $list_of_entries["quantity"] > 0 ? "<hr>" : "";

	$do_not_touch_this_field = Language(['creator', 'do-not-touch-this-field'], 'dashboard');

	for ($j = 0; $j < $list_of_entries["quantity"]; $j++) {
		$j_entry = $list_of_entries["load"][$j]["entrada"] ?? "";

		$form .= $view_creator_entries_details(
			j: $j,
			type: Language('type'),
			j_entry: $j_entry,
			j_title: $list_of_entries["load"][$j]["titulo"] ?? "",
			j_title_alternative: $list_of_entries["load"][$j]['titulo-alternativo'] ?? '',
			title_zero: !$j ? $do_not_touch_this_field : 'Post',
			title_zero_title: !$j ? $do_not_touch_this_field : 'blog / post / juego / web / ...',
			title_summary: !$j ? Language('home') : ($j_entry ? $j_entry : Language('freely')),
			disabled_input: !$j ? "disabled" : "",
			disabled_input_select: !$j ? "selected" : "",
			is_poster: $j > 0 && !empty($list_of_entries["load"][$j]["poster"] ?? "") ? "selected" : "",
			title: Language('title'),
			games: Language('games'),
			thumbnail: Language('thumbnail'),
			poster: Language('poster'),
			the_best_games: Language(['creator', 'the-best-games'], 'dashboard'),
			title_in_the_entries: Language(['creator', 'title-in-the-entries'], 'dashboard')
		);
	
		$form .= $j < $list_of_entries["quantity"] - 1 ? "<hr>" : "";
	}
	
	$form .= "<hr><input class=\"boton\" type=\"submit\" name=\"actualizar-entradas\" value=\"" . Language('update') . "\">";
	$form .= "</div>";

	return !isset($_GET['creador']) && !isset($_GET['disable-entries']) ?
		"<form method=\"get\">{$form}</form>"
		: "<a href=\"?ap=creator\" class=\"boton-2\"><i class=\"fas fa-eye\"></i> " . Language("show") . "</a>";
};

$containerPublish = function ($allData) use ($render, $view_buttons_section, $formEntries) {
	$content = "<div class=\"flex flex-column gap-8\">";
	
	foreach ($allData as $key => $value) {
		$content .= $render->dropdown([
			"id" => "container-publish-{$key}",
			"title" => $key,
			"checked" => false,
			"content" => "<div class=\"flex flex-column gap-4\">" . ($view_buttons_section($key, $value)) . "</div>"
		]);
	}

	$content .= $render->dropdown([
		"id" => "container-publish-entries",
		"title" => "entries",
		"checked" => false,
		"content" => "<div class=\"flex flex-column gap-4\">{$formEntries()}</div>"
	]);

	$content .= "</div>";

	// Print
	return $render->dropdown([
		"id" => "container-publish",
		"escape_title" => true,
		"title" => Language(['creator', 'message'], 'dashboard'),
		"checked" => !isset($_GET['creador']),
		"content" => $content
	]);
};

// Render the view
echo $containerPublish($search($ruta, $visits));


/* ------------------- Creators --------------------- */
$confirm_get_creator_and_route_file_path_exists = $Creator["submit_get_creator"] && $Creator["creator_route_file_path_exists"];

$alert_view = <<<HTML
	<section class="boton-2" style="background-color: red; color: white; font-weight: bold;"><i class="fas fa-exclamation-triangle"></i> %s</section>
HTML;

echo $Creator["submit_get_creator"] && !$Creator["creator_route_file_path_exists"] ?
	sprintf($alert_view, Language(
		['creator', 'creator-no-exists'], 'dashboard',
		['value' => "<strong>{$Creator['get_creator']}</strong>"]
)) : '';

if ($confirm_get_creator_and_route_file_path_exists) { ?>
	<form method="post" >
		<?= $render->dropdown([
			"id" => "container-creator",
			"title" => $creator_translate[$Creator["get_creator"]],
			"checked" => true,
			"content" => "<div class=\"flex flex-column gap-4\">" . (require RAIZ . 'app/views/admin/partial/creator-view.php') . "</div>"
		]); ?>
	</form>
<?php } ?>