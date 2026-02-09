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

global $Global, $Creador;

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
/*
echo "<pre>";
var_dump($search($ruta, $visits));
echo "</pre>";
*/
?>

<?php $containerPublish = function ($section, $allData, $input, $render) use ($Web, $creator_translate, $visits, $list_of_entries) {
	$data = $allData ?? [];
	$content = "<div class=\"flex flex-column gap-8\">";
	
	foreach ($data as $key => $value) {
		$buttons = function ($type, $list) use ($creator_translate) {
			$return = "";

			foreach ($list as $key => $value) {
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

		$content .= $render->dropdown([
			"id" => "container-publish-{$key}",
			"title" => $key,
			"checked" => false,
			"content" => "<div class=\"flex flex-column gap-4\">" . ($buttons($key, $value)) . "</div>"
		]);
	}

	// Form entries
	$formEntries = function() use ($input, $list_of_entries) {
		$quantity_entries = Language(['creator', 'quantity-entries'], 'dashboard');
		$quantity = Language('quantity');
		$title = Language('title');
		$home = Language('home');
		$freely = Language('freely');
		$titles = Language('titles');
		$games = Language('games');
		$update = Language('update');
		$type = Language('type');
		$thumbnail = Language('thumbnail');
		$poster = Language('poster');
		$do_not_touch_this_field = Language(['creator', 'do-not-touch-this-field'], 'dashboard');
		$the_best_games = Language(['creator', 'the-best-games'], 'dashboard');
		$title_in_the_entries = Language(['creator', 'title-in-the-entries'], 'dashboard');
		$attention_update = Language(['creator', 'attention-update'], 'dashboard');

		$show = !isset($_GET['creador']) && !isset($_GET['disable-entries']);
		$button_show = "<a href=\"?ap=creator\" class=\"boton-2\"><i class=\"fas fa-eye\"></i> " . Language("show") . "</a>";

		$form = "<div class=\"flex flex-column gap-8\">";

		$form .= <<<HTML
			<p class="t-center" style="background-color: red; color: white; font-weight: bold; padding: 2px 6px 2px 6px; margin-bottom: 4px;">{$attention_update}</p>
			<input type="text" name="ap" value="creator" readonly hidden required>
			<label class="flex flex-between gap-4">
				<span>$quantity:</span>
				<input class="form-campo-pequeno" placeholder="1" type="number" min="0" max="99" name="cantidad-entradas" value="{$list_of_entries["quantity"]}">
			</label>
		HTML;

		$form .= $list_of_entries["quantity"] > 0 ? "<hr>" : "";

		for ($j = 0; $j < $list_of_entries["quantity"]; $j++) {
			$j_title = $list_of_entries["load"][$j]["titulo"] ?? "";
			$j_entry = $list_of_entries["load"][$j]["entrada"] ?? "";
			$is_poster = $j > 0 && !empty($list_of_entries["load"][$j]["poster"] ?? "") ? "selected" : "";
			$j_title_alternative = $list_of_entries["load"][$j]['titulo-alternativo'] ?? '';
			$disabled_input = !$j ? "disabled" : "";
			$disabled_input_select = !$j ? "selected" : "";
			$title_summary = !$j ? $home : ($j_entry ? $j_entry : $freely);

			$title_zero = !$j ? $do_not_touch_this_field : 'Post';
			$title_zero_title = !$j ? $do_not_touch_this_field : 'blog / post / juego / web / ...';

			$form .= <<<HTML
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
		
			$form .= $j < $list_of_entries["quantity"] - 1 ? "<hr>" : "";
		}
		
		$form .= <<<HTML
			<hr><input class="boton" type="submit" name="actualizar-entradas" value="{$update}">
		HTML;

		$form .= "</div>";

		return $show ? "<form method=\"get\">{$form}</form>" : $button_show;
	};

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
?>

<?= $containerPublish("creator", $search($ruta, $visits), $input, $render) ?>


<?php if (isset($_GET['creador'])) {
	$Global['get_creador'] = Daamper::$scripts->normalizar2($_GET['creador']);
	$ruta_creador = __DIR__ . "/creators/{$Global['get_creador']}-view.php"; ?>
	<?= !file_exists($ruta_creador) ?
		"<section class='panel'><section class='form'><p>".(Language(['creator', 'creator-no-exists'], 'dashboard', ['value' => "<strong>{$Global['get_creador']}</strong>"]))."</p></section></section>" : '' ?>
	<?php if (file_exists($ruta_creador)) { ?>
		<form method="post" class="panel" style="gap: 8px;">
			<?php $files = glob("{$Web['directorio']}*");
			$directorios = [];
			foreach ($files as $file) {
				if (!is_file($file) && !in_array(basename($file), ['app', 'assets', 'auth', 'p', 'admin', 'process', 'database'])) {
					$directorios[basename($file) . '/'] = ucfirst(basename($file)) . '/';
				}
			}
			
			$ruta_campos_predeterminados = "database/creator/field-default.json";
			if (file_exists(RAIZ .  $ruta_campos_predeterminados)) {
				$Predeterminados = Daamper::$data->Read("creator/field-default")[$Global["get_creador"]];
			} else {
				echo "<section class='form t-center'><p>" . Language("file-no-exists", "global", ["value" => $ruta_campos_predeterminados]) . "</p></section>";
			}
			if (isset($Predeterminados)){
				for ($i = 1; $i <= 3; $i++) {
					if (!isset($Predeterminados['contenedor_predeterminado'][$i]) or isset($Predeterminados['contenedor_predeterminado'][$i]) && $Predeterminados['contenedor_predeterminado'][$i]) { ?>
						<section class="form" style="margin-top: 0; margin-bottom: 0;">
					<?php if ($i == 2) {
							echo '<strong>'.(Language('creator')).' ~ ' . $Global['get_creador'] . '</strong><hr>';
							require $ruta_creador;
						}
						if ($i == 1 || $i == 3) {
							#echo '<section>';
							$lista_campos_predeterminados[1] = [
								['name' => 'titulo', 'contenido' =>
								pInput(['name' => 'titulo', 'placeholder' => (Language('title')), 'label' => false, 'texto' => (Language('title')), 'required' => true])],
								['name' => 'descripcion', 'contenido' =>
								pInput(['name' => 'descripcion', 'placeholder' => (Language(['creator', 'description'], 'dashboard')), 'label' => false, 'texto' => (Language(['creator', 'description'], 'dashboard')), 'required' => true])],
								['name' => 'meta_descripcion', 'contenido' =>
								pInput(['name' => 'meta_descripcion', 'placeholder' => (Language(['creator', 'meta-description'], 'dashboard')), 'label' => false, 'texto' => (Language(['creator', 'meta-description'], 'dashboard')), 'required' => true])],
								['name' => 'catalogo', 'contenido' =>
								pInput(['name' => 'catalogo', 'placeholder' => (Language(['creator', 'catalog'], 'dashboard')), 'label' => false, 'texto' => (Language(['creator', 'catalog'], 'dashboard')), 'required' => true])],
								['name' => 'meta_etiquetas', 'contenido' =>
								pInput(['name' => 'meta_etiquetas', 'placeholder' => (Language(['creator', 'meta-tags'], 'dashboard')), 'label' => false, 'texto' => (Language(['creator', 'meta-tags'], 'dashboard')), 'required' => true])]
							];

							$lista_campos_predeterminados[3] = [
								['name' => 'a_subir_imagen', 'contenido' =>
								pEnlace(['class' => '', 'texto' => (Language('upload-image')), 'icono' => 'fas fa-external-link-alt', 'target' => '_blank', 'href' => '?ap=upload-image'])],
								['name' => 'miniatura', 'contenido' =>
								pSelectArchivos(['name' => 'miniatura', 'label' => true, 'texto' => (Language('thumbnail')), 'ruta' => $Web['directorio'] . 'assets/img/', 'tipo_archivos' => 'png,jpg,jpeg,gif'])],
								['name' => 'miniatura_url', 'contenido' =>
								pInput(['name' => 'miniatura_url', 'type' => 'url', 'placeholder' => (Language('thumbnail')) . ' URL ('.(Language('optional')).')', 'label' => false, 'texto' => (Language('thumbnail')) . ' URL']) . '<hr>'],
								['name' => 'anuncio', 'contenido' =>
								pCheckboxBoton(['nameidclass' => 'anuncio', 'texto' => (Language('announcement')), 'icono' => 'fas fa-newspaper', 'checked' => true])],
								['name' => 'privado', 'contenido' =>
								pCheckboxBoton(['nameidclass' => 'privado', 'texto' => (Language(['creator', 'private'], 'dashboard')), 'icono' => 'fas fa-eye-slash'])],
								['name' => 'comentar', 'contenido' =>
								pCheckboxBoton(['nameidclass' => 'comentar', 'texto' => (Language('comment')), 'icono' => 'fas fa-comment-alt', 'checked' => true])],
								['name' => 'comentarios', 'contenido' =>
								pCheckboxBoton(['nameidclass' => 'comentarios', 'texto' => (Language('comments')), 'icono' => 'fas fa-comments', 'checked' => true]) . '<hr>'],
								['name' => 'ruta', 'contenido' =>
								pInput(['name' => 'ruta', 'placeholder' => (Language('route')).'/', 'style' => 'width: 100%;', 'label' => false, 'texto' => (Language('route')), 'title' => (Language('post-route')), 'minlength' => 1])],
								['name' => 'archivo', 'contenido' =>
								pInput(['name' => 'archivo', 'placeholder' => (Language('file')), 'style' => 'width: 100%;', 'label' => false, 'texto' => (Language('file')), 'title' => (Language('file')), 'minlength' => 1, 'required' => true])]
							];

							foreach ($lista_campos_predeterminados[$i] as $value) {
								if (!isset($Predeterminados['campo_predeterminado'][$value['name']]) or isset($Predeterminados['campo_predeterminado'][$value['name']]) && $Predeterminados['campo_predeterminado'][$value['name']]) {
									echo $value['contenido'] . ($Predeterminados['campo_predeterminado'][$value['name']] !== true ? $Predeterminados['campo_predeterminado'][$value['name']] : ' ');
								}
							}
							if ($i == 3) {
								if (!isset($Predeterminados['campo_predeterminado']['mostrar_en_index']) or isset($Predeterminados['campo_predeterminado']['mostrar_en_index']) && $Predeterminados['campo_predeterminado']['mostrar_en_index']) {
									if (!file_exists(RAIZ . 'database/post/' . str_replace('bo_', '', $Global['get_archivo']))) {
										echo '<hr>' . pCheckboxBoton(['nameidclass' => 'mostrar_en_index', 'texto' => (Language(['creator', 'show-in-the-list'], 'dashboard')), 'icono' => 'fas fa-eye', 'checked' => true]);
									}
								}
							}
						}
						echo '</section>';
					}
				}
			} ?>
				<section class="form">
					<?php if (isset($_GET['tipo']) && isset($_GET['archivo'])) {
						if (in_array($_GET['tipo'], ['borrador', 'publicacion'])) {
							if (file_exists(RAIZ . 'database/post/' . str_replace('bo_', '', $Global['get_archivo']))) {
								echo '<section class="flex-between">' .
									pCheckboxBoton(['nameidclass' => 'volver_a_mostrarlo_como_nuevo', 'texto' => (Language(['creator', 'show-it-as-new'], 'dashboard')), 'icono' => 'fas fa-history', 'checked' => false]) .
									pCheckboxBoton(['nameidclass' => 'quitarlo_del_index', 'texto' => (Language(['creator', 'remove-it-from-the-list'], 'dashboard')), 'icono' => 'fas fa-times-circle', 'checked' => false]) .
									'</section><hr>';
							}
						}
					} ?>
					<section class="flex-between">
						<?= pInput(['type' => 'hidden', 'name' => 'creador', 'value' => $Global['get_creador'], 'des_session' => true]) ?>
						<?= pInput(['type' => 'hidden', 'name' => 'pubo', 'value' => $Global['get_tipo'], 'des_session' => true]) ?>
						<?= pInput(['type' => 'hidden', 'name' => 'db_archivo', 'value' => $Global['get_archivo'], 'des_session' => true]) ?>
						<button type="submit" name="refrescar" value="true" class="boton-2"><i class="fas fa-sync-alt"></i> <?= Language('refresh') ?></button>
						<button type="submit" name="mostrar" value="true" class="boton"><i class="fas fa-eye"></i> <?= Language('show') ?></button>
					</section>
					<hr>
					<?= Daamper::$scripts->xv("creator"); ?>
				</section>
		</form>
<?php }
} ?>