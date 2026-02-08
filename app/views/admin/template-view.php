<?php
/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  template-view.php                                                     */
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
?>
<form method="post" action="process/actions.php">
<?php $Apartado='template'; $template = $Web["template"] ?? [];
$glob_templates = glob('../database/template/*.json');
$show_use_template = !empty($_GET['plantilla']) && file_exists("../database/template/{$_GET['plantilla']}") ? true : false;

use Core\Render;
$render = new Render;

function newTemplate($template, $render, $glob_templates, $show_use_template){
	$render_templates_links = function () use ($glob_templates): string {
		$content = "";
		foreach ($glob_templates as $plantilla) {
			if (substr(basename($plantilla), 0, 4) != 'scr-' && !in_array(basename($plantilla), ["template.json", "scr-template.json"])) {
				$content .= '<a class="boton-2" href="?ap=template&plantilla='.basename($plantilla).'&accion=mostrar">'.str_replace([".php", ".json"], "", basename($plantilla)).'</a>';
			}
		}
		return $content;
	};

	$render_template_file_and_quantity_container_and_restore = function() use ($template): string {
		$content = "<nav class=\"flex gap-4\">";
		$content .= pInput(["name" => "archivo_plantilla", "value" => $template['archivo_plantilla'] ?? "", "title" => Language("template"), "placeholder" => (strtolower(Language("template"))) . ".json", "class" => "flex-1"]);
		$content .= pInput(["name" => "cantidad_contenedores", "type" => "number", "value" => $template['cantidad_contenedores'] ?? 1, "title" => Language("quantity"), "class" => "campo form-campo-pequeno", "min" => 1, "max" => 50, "required" => true]);
		$content .= "</nav>";
		$content .= "<hr>";
		$content .= "<a class=\"boton-2 boton-mini\" href=\"?ap=template&accion=restaurar\"><span class=\"icon icon--left\"><i class=\"fas fa-history\"></i></span><span class=\"text\">" . Language("restore") . "</span></a>";
		return $content;
	};

	$render_use_template = function(): string {
		$content = "<nav class=\"flex flex-between gap-4\">";
		$content .= "<a href=\"#procesa_actualizar\" class=\"boton-2 boton-mini\"><i class=\"fas fa-hand-pointer\"></i> " . Language('use') . "</a>";
		$content .= "<a class=\"boton boton-mini\" href=\"?ap=template&plantilla=" . (Daamper::$scripts->normalizar($_GET['plantilla'])) . "&accion=eliminar\"><i class=\"fas fa-trash\"></i> " . Language('delete') . "</a>";
		$content .= "</nav>";
		return $content;
	};

	$render_header = [
		"id" => "template",
		"title" => "template",
		"checked" => $show_use_template ? true : (empty($template["cantidad_contenedores"]) ? true : false),
		
		"button_right_show" => true,
		"button_right_id" => "scripts",
		"button_right_text" => "scripts",
		"button_right_name" => "cargar_scripts",
		"button_right_checked" => $template["cargar_scripts"] ?? "",

		"content_before" => "<nav class=\"flex flex-column gap-8\">",
		"content_after" => "</nav>",

		"content" => $render->dropdown([
			"id" => "templates",
			"title" => "templates",
			"content" => $render_templates_links,

			"after" => (
				$render->dropdown([
					"id" => "template-selected",
					"title" => "selected",
					"checked" => empty($template["cantidad_contenedores"]),
					"content" => $render_template_file_and_quantity_container_and_restore
				]).
				$render->dropdown([
					"id" => "use-template",
					"title" => "use",
					"show" => $show_use_template,
					"checked" => $show_use_template,
					"content" => $render_use_template
				])
			)
		])
	];

	echo $render->dropdown($render_header) . "<hr>";

	$render_modal_show_fields = function(string $name, array $array, bool $is_element = false, bool $isset_fields_elements = false, array $array2 = []) use ($render): string {
		$values = ["title", "content", "container", "styles", "commands", "scripts", "empty"];
		$option = [];
		foreach ($values as $value) {
			$option[] = [
				"title" => $value,
				"value" => $value,
				"name" => "{$name}[]",
				"checked" => $is_element && $isset_fields_elements ? in_array($value, $array2) : in_array($value, $array)
			];
		}
		return $render->modal([
			"title" => "fields",
			"id" => $name,
			"option" => $option
		]);
	};

	$render_container = function (int $container, string $render_content) use ($render, $template): string {
		return $render->dropdown([
			"escape_title" => true,
			"title" => !empty($template["nombre_contenedor_{$container}"]) ? (Language(str_replace([" ", "_"], "-", strtolower($template["nombre_contenedor_{$container}"]))) ?? $template["nombre_contenedor_{$container}"]) : Language("container") . " #$container",
			"id" => "contenedor_{$container}",
			"button_right_show" => true,
			"button_right_id" => "mostrar_contenedor_{$container}",
			"button_right_name" => "mostrar_contenedor_{$container}",
			"button_right_checked" => $template["mostrar_contenedor_{$container}"] ?? "",
			"button_right_icon_inactive" => "fas fa-eye-slash",
			"button_right_icon_active" => "fas fa-eye",
			"button_right_text" => "",
			"content_before" => "<nav class=\"flex flex-column gap-8\">",
			"content_after" => "</nav>",
			"content" => $render_content,
		]);
	};

	$render_container_settings = function(int $container, string $mcplec, array $mcplec_array) use ($render, $template, $render_modal_show_fields): string {
		$content = '<div class="flex flex-between items-center gap-4">';
		$content .= '<div class="flex">';
		$content .= $render->select([
			"title" => "container-type",
			"name" => "tipo_contenedor_{$container}",
			"selected" => $template["tipo_contenedor_{$container}"] ?? "",
			"option" => [
				""				=> "container-type",
				"components"	=> "components",
				"normal"		=> "normal",
				"header"		=> "header",
				"header-bar"	=> "header-bar",
				"sidebar"		=> "sidebar",
				"open-content"	=> "open-content",
				"main-header"	=> "main-header",
				"main"			=> "main",
				"main-footer"	=> "main-footer",
				"aside"			=> "aside",
				"article"		=> "article",
				"close-content"	=> "close-content",
				"footer"		=> "footer",
				"copyright"		=> "copyright"
			]
		]);

		$content .= $render->input([
			"title" => "container-name",
			"placeholder" => "container-name",
			"name" => "nombre_contenedor_{$container}",
			"value" => $template["nombre_contenedor_{$container}"] ?? ""
		]);

		$content .= $render->input([
			"title" => "item-quantity",
			"escape_placeholder" => true,
			"placeholder" => 1,
			"name" => "cantidad_elementos_contenedor_{$container}",
			"value" => $template["cantidad_elementos_contenedor_{$container}"] ?? "",
			"class" => "form-campo-pequeno",
			"type" => "number",
			"min" => 0,
			"max" => 50
		]);
		$content .= "</div>";

		$content .= $render_modal_show_fields($mcplec, $mcplec_array);
		$content .= "</div><hr>";
		$content .= "<div class=\"flex flex-column gap-4\">";
		$content .= $render->textarea([
			"title" => "open-container",
			"name" => "div_abrir_contenedor_{$container}",
			"escape_placeholder" => true,
			"placeholder" => htmlspecialchars("<aside class=\"aside\">\n  [Return=PageName]"),
			"text" => $template["div_abrir_contenedor_{$container}"] ?? "",
			"rows"  => 2,
		]);
		$content .= $render->textarea([
			"title" => "close-container",
			"name" => "div_cerrar_contenedor_{$container}",
			"escape_placeholder" => true,
			"placeholder" => htmlspecialchars("  [View=components/emojis]\n</aside>"),
			"text" => $template["div_cerrar_contenedor_{$container}"] ?? "",
			"rows"  => 2,
		]);
		$content .= "</div>";

		return $render->dropdown([
			"title" => "settings",
			"id" => "settings_contenedor_{$container}",
			"button_right_show" => false,
			"content" => $content
		]);
	};

	$render_container_element = function(int $container, int $element, array $mcplec_array) use ($render, $template, $render_modal_show_fields): string {
		$content = "";

		$content .= "<details><summary>" . Language("settings") . "</summary><section class=\"flex flex-between gap-8\">";
			$content .= $render->input([
				"title" => "item-name",
				"placeholder" => "item-name",
				"name" => "nombre_elemento_{$element}_contenedor_{$container}",
				"value" => $template["nombre_elemento_{$element}_contenedor_{$container}"] ?? "",
				"class" => "flex-1"
			]);

			$mcpeec = "mostrar_campos_para_el_elemento_{$element}_contenedor_{$container}";
			$mcpeec_array = !empty($template[$mcpeec]) ? explode(",", $template[$mcpeec]) : [];
			$mcpeec_isset = isset($template[$mcpeec]);

			$content .= $render_modal_show_fields($mcpeec, $mcplec_array, true, $mcpeec_isset, $mcpeec_array);
		$content .= "</section></details>";

		$content .= "<div class=\"flex flex-column gap-4\">";
			$content .= "<input type=\"text\" name=\"titulo_campos_default_elemento_{$element}_contenedor_{$container}\" value=\"" . (trim(htmlspecialchars($template["titulo_campos_default_elemento_{$element}_contenedor_{$container}"] ?? ""))) . "\" placeholder=\"" . Language("title") . "\" title=\"" . Language("title") . "\"" . (!($mcpeec_isset ? in_array("title", $mcpeec_array) : in_array("title", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") . ">";
			$content .= "<textarea rows=\"7\" name=\"contenido_campos_default_elemento_{$element}_contenedor_{$container}\" placeholder=\"" . Language("content") . "\" title=\"" . Language("content") . "\"" . (!($mcpeec_isset ? in_array("content", $mcpeec_array) : in_array("content", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") . ">" . (trim(htmlspecialchars($template["contenido_campos_default_elemento_{$element}_contenedor_{$container}"] ?? ""))) . "</textarea>";
			$content .= "<textarea rows=\"1\" name=\"div_abrir_campos_default_elemento_{$element}_contenedor_{$container}\" placeholder=\"" . htmlspecialchars('<div class="">') . "\" title=\"" . Language("open-element-container") . "\"" . (!($mcpeec_isset ? in_array("container", $mcpeec_array) : in_array("container", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") . ">" . (trim(htmlspecialchars($template["div_abrir_campos_default_elemento_{$element}_contenedor_{$container}"] ?? ""))) . "</textarea>";
			$content .= "<textarea rows=\"1\" name=\"div_cerrar_campos_default_elemento_{$element}_contenedor_{$container}\" placeholder=\"" . htmlspecialchars('</div') . "\" title=\"" . Language("close-element-container") . "\"" . (!($mcpeec_isset ? in_array("container", $mcpeec_array) : in_array("container", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") . ">" . (trim(htmlspecialchars($template["div_cerrar_campos_default_elemento_{$element}_contenedor_{$container}"] ?? ""))) . "</textarea>";
			$content .= "<label class=\"flex flex-between gap-4\"" . (!($mcpeec_isset ? in_array("container", $mcpeec_array) : in_array("container", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") . ">";
			$content .= "<span>" . Language("hidden-tags") . ":</span>";
			$content .= $render->inputCheck([
				"id" => "ocultar_etiquetas_contenedor_campos_default_elemento_{$element}_contenedor_{$container}",
				"name" => "ocultar_etiquetas_contenedor_campos_default_elemento_{$element}_contenedor_{$container}",
				"checked" => !empty($template["ocultar_etiquetas_contenedor_campos_default_elemento_{$element}_contenedor_{$container}"])
			]);
			$content .= "</label>";
			$content .= "<textarea rows=\"4\" name=\"estilos_campos_default_elemento_{$element}_contenedor_{$container}\" placeholder=\"" . htmlspecialchars(".boton { color: red; background-color: white; }\n.form { padding: 4px; border-radius: 4px; }\n.check:checked { color: white; box-shadow: 0px 0px 1px 1px #2f9; }") . "\" title=\"" . Language("close-element-container") . "\"" . (!($mcpeec_isset ? in_array("styles", $mcpeec_array) : in_array("styles", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") . ">" . (trim(htmlspecialchars($template["estilos_campos_default_elemento_{$element}_contenedor_{$container}"] ?? ""))) . "</textarea>";
		
			$content .= "<details " . (!($mcpeec_isset ? in_array("commands", $mcpeec_array) : in_array("commands", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") . "><summary>" . Language("add-to-this-form")  . " <small> ~ " . Language("beta") . "</small>" . "</summary><section>";
				$content .= "<textarea rows=\"7\" name=\"comandos_campos_default_elemento_{$element}_contenedor_{$container}\" placeholder=\"" . htmlspecialchars("[Return=PageName]\n[Form=InputModal name=".'""'."]\n[Form=InputModalQuantity name=".'""'."]\n[Form=InputLink name=".'""'."]\n[Return=LinkNew name=".'""'."]\n[Return=LinkNewAll name=".'""'."]\n[Return=LinkNewAllSession name=".'""'."]\n[Return=LinkNewAllNonSession name=".'""'."]\n[Return=Visits]\n[View=components/emojis]\n[Return=CoreVersion]") . "\" title=\"" . Language("commands") . "\"" . (!($mcpeec_isset ? in_array("scripts", $mcpeec_array) : in_array("scripts", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") . ">" . (trim(htmlspecialchars($template["comandos_campos_default_elemento_{$element}_contenedor_{$container}"] ?? ""))) . "</textarea>";
			$content .= "</section></details>";
			$content .= "<div " . (!($mcpeec_isset ? in_array("scripts", $mcpeec_array) : in_array("scripts", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") . ">";			
			global $Web;
			$content .= !empty($template["comandos_campos_default_elemento_{$element}_contenedor_{$container}"]) ? (new Template($template, $Web))->commands($template["comandos_campos_default_elemento_{$element}_contenedor_{$container}"], $container, $element) : '';
			$content .= "</div>";
		$content .= "</div>";

		return $render->dropdown([
			"escape_title" => true,
			"title" =>
			!empty($template["nombre_elemento_{$element}_contenedor_{$container}"]) ? (Language(str_replace([" ", "_"], "-", strtolower($template["nombre_elemento_{$element}_contenedor_{$container}"]))) ?? $template["nombre_elemento_{$element}_contenedor_{$container}"]) : Language("element") . " #$element",
			"id" => "elemento_{$element}_contenedor_{$container}",
			
			"button_right_show" => true,
			"button_right_id" => "mostrar_elemento_{$element}_contenedor_{$container}",
			"button_right_name" => "mostrar_elemento_{$element}_contenedor_{$container}",
			"button_right_checked" => $template["mostrar_elemento_{$element}_contenedor_{$container}"] ?? "",
			"button_right_icon_inactive" => "fas fa-eye-slash",
			"button_right_icon_active" => "fas fa-eye",
			"button_right_text" => "",

			"content_before" => "<nav class=\"flex flex-column gap-8\">",
			"content_after" => "</nav>",
			"content" => $content
		]);
	};

	echo "<div class=\"flex flex-column gap-8\">";
	if(!empty($template["cantidad_contenedores"]) && is_numeric($template["cantidad_contenedores"])){
		for($i = 1; $i <= $template["cantidad_contenedores"] ?? 1; $i++){
			$mcplec = "mostrar_campos_para_los_elementos_contenedor_{$i}";
			//$template[$mcplec] = !isset($template[$mcplec]) ? "title,content,container,styles,commands,scripts,empty" : $template[$mcplec];
			$mcplec_array = !empty($template[$mcplec]) ? explode(",", $template[$mcplec]) : [];
			$content = $render_container_settings($i, $mcplec, $mcplec_array);
			
			if(!empty($template["cantidad_elementos_contenedor_{$i}"]) && is_numeric($template["cantidad_elementos_contenedor_{$i}"])){
				for($ii = 1; $ii <= $template["cantidad_elementos_contenedor_{$i}"] ?? 1; $ii++){
					$content .= $render_container_element($i, $ii, $mcplec_array);
				}
			}

			echo $render_container($i, $content);
		}
	}
	echo pInput(['type'=>'submit','class'=>'boton','id'=>'procesa_actualizar','name'=>"procesa_template",'value'=>!empty($show_use_template) ? Language('use') : Language('update')]);
	echo '<div style="text-align: center; padding: 24px 8px;">';
		echo Daamper::$scripts->xv("template");
	echo '</div>';
	echo "</div>";
}

function clasicTemplate($Apartado, $glob_templates, $render){ global $Web; $template = $Web["template"];

 $render_modal_show_fields = function(string $name, array $array, bool $is_element = false, bool $isset_fields_elements = false, array $array2 = []) use ($render): string {
	$values = ["title", "content", "container", "styles", "commands", "scripts", "empty"];
	$option = [];
	foreach ($values as $value) {
		$option[] = [
			"title" => $value,
			"value" => $value,
			"name" => "{$name}[]",
			"checked" => $is_element && $isset_fields_elements ? in_array($value, $array2) : in_array($value, $array)
		];
	}
	return $render->modal([
		"title" => "fields",
		"id" => $name,
		"option" => $option
	]);
 };

 ?>
	<section class="panel">
		<section class="form" style="margin-bottom: 0;">
			<section class="flex-between">
				<strong><?= Language('template') ?></strong>
				<section>
					<?=
					pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['icono' => 'fas fa-sitemap', 'name' => 'cargar_scripts','texto-2'=>Language('scripts'),'title'=>Language('enable-or-disable-scripts')])
					?>
				</section>
			</section>
			<details>
				<summary><?= Language("templates"); ?></summary>
				<section>
					<?php
						foreach ($glob_templates as $plantilla) {
							if (substr(basename($plantilla), 0, 4) != 'scr-' && !in_array(basename($plantilla), ["template.json", "scr-template.json"])) {
								echo '<a class="boton-2" href="?ap=template&plantilla='.basename($plantilla).'&accion=mostrar">'.str_replace([".php", ".json"], "", basename($plantilla)).'</a>';
							}
						}
					?>
				</section>
			</details>
			<details>
				<summary><?= Language('selected') ?></summary>
				<section class="flex flex-column gap-4">
					<div class="flex">
						<?= pInput(['class' => "flex-1", 'placeholder'=>strtolower(Language('template')).'.php ('.Language('optional').')','title'=>Language('template'),'name'=>'archivo_plantilla','style'=>'width: 100%;','value'=>(isset($Web[$Apartado]['archivo_plantilla']) ? trim(htmlspecialchars($Web[$Apartado]['archivo_plantilla'])) : '')]); ?>
						<?= pInput(['placeholder'=>'4','class'=>'form-campo-pequeno','title'=>Language('quantity'),'name'=>'cantidad_contenedores','label'=>false,'class_label'=>'flex-between','texto'=>Language('quantity'),'min'=> 0, 'max'=> 99,'type'=>'number','value'=>(isset($Web[$Apartado]['cantidad_contenedores']) ? trim(htmlspecialchars($Web[$Apartado]['cantidad_contenedores'])) : 0),'required' => true]); ?>
					</div>
					<hr>
					<div>
						<a class="boton-2 boton-mini" href="?ap=template&accion=restaurar"><i class="fas fa-history"></i> <?= Language('restore') ?></a>
					</div>
				</section>
			</details>
			<?php if (isset($_GET['plantilla']) && !empty($_GET['plantilla']) && file_exists("../database/template/{$_GET['plantilla']}")): ?>
			<details open>
				<summary><?= Language('use') ?></summary>
				<section class="flex-between">
					<a href="#procesa_actualizar" class="boton-2 boton-mini"><i class="fas fa-hand-pointer"></i> <?= Language('use') ?></a>
					<a class="boton boton-mini" href="?ap=template&plantilla=<?= Daamper::$scripts->normalizar($_GET['plantilla']) ?>&accion=eliminar"><i class="fas fa-trash"></i> <?= Language('delete') ?></a>
				</section>
			</details>
			<?php endif; ?>
		</section>
		<?php if(isset($Web[$Apartado]['cargar_scripts']) && empty($Web[$Apartado]['cargar_scripts']) &&
			!file_exists($Web['directorio'].'app/actions/admin/content/src/template.php')): ?>
			<section class="form" style="background-color: red; color: white;">
				<p><?= Language('file-no-exists', 'global', ['value' => '<strong>src/template</strong>']) ?></p>
			</section>
		<?php endif; ?>
	</section>
	<?php if(isset($Web[$Apartado]['cantidad_contenedores']) && !empty($Web[$Apartado]['cantidad_contenedores'])):
		for($i = 1; $i <= $Web[$Apartado]['cantidad_contenedores']; $i++): $Web[$Apartado]['contenedor'] = $i; ?>
		<?php
			$mcplec = "mostrar_campos_para_los_elementos_contenedor_{$i}";
			//$template[$mcplec] = !isset($template[$mcplec]) ? "title,content,container,styles,commands,scripts,empty" : $template[$mcplec];
			$mcplec_array = !empty($template[$mcplec]) ? explode(",", $template[$mcplec]) : [];
		?>
		<section class="panel" style="margin: 0px auto; align-content: center; gap: 4px; padding: 4px; flex-direction: column;">
			<section class="form" style="margin-bottom: 0;">
				<section class="flex-between">
					<strong><?= (isset($Web[$Apartado]['nombre_contenedor_'.$i]) && !empty($Web[$Apartado]['nombre_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['nombre_contenedor_'.$i])) : "Sección #$i") ?></strong>
					<?= pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['name'=>'mostrar_contenedor_'.$i,'title'=>Language('show-or-hide-section')]); ?>
				</section>
				<details>
					<summary><?= Language('expand') ?></summary>
					<details>
						<summary><?= Language('settings') ?></summary>
						<section class="flex flex-column gap-4">
							<section class="flex flex-between">
								<div class="">
									<?= pSelect(['title'=>Language('container-type'),  'option' => [
										'components' => Language('components'),
										'normal' => Language('normal'),
										'header' => Language('header'),
										'header-bar' => Language('header-bar'),
										'sidebar' => Language('sidebar'),
										'open-content' => Language('open-content'),
										'main-header' => Language('main-header'),
										'main' => Language('main'),
										'main-footer' => Language('main-footer'),
										'aside' => Language('aside'),
										'article' => Language('article'),
										'close-content' => Language('close-content'),
										'footer' => Language('footer'),
										'copyright' => Language('copyright')
										], 'name' => "tipo_contenedor_$i", 'value'=>(isset($Web[$Apartado]['tipo_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['tipo_contenedor_'.$i])) : '')]) ?>
									<?= pInput(['placeholder' => Language('container-name'),'title'=>Language('container-name'),'name'=>'nombre_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['nombre_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['nombre_contenedor_'.$i])) : '')]); ?>
									<?= pInput(['placeholder'=>'1','class'=>'form-campo-pequeno','title'=>Language('item-quantity'),'name'=>'cantidad_elementos_contenedor_'.$i,'label'=>false,'texto'=>Language('item-quantity'),'min'=>0,'max'=>99,'type'=>'number','value'=>(isset($Web[$Apartado]['cantidad_elementos_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['cantidad_elementos_contenedor_'.$i])) : 0)]) ?>
								</div>
								<?= $render_modal_show_fields($mcplec, $mcplec_array); ?>
							</section>
							<section class="flex flex-column gap-4">
								<?= pTextarea(['title'=>Language('open-container'),'placeholder'=>htmlspecialchars("<aside class=\"aside\">\n  [Return=PageName]"),'name'=>'div_abrir_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['div_abrir_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['div_abrir_contenedor_'.$i])) : '')]) ?>
								<?= pTextarea(['title'=>Language('close-container'),'placeholder'=>htmlspecialchars("  [View=components/emojis]\n</aside>"),'name'=>'div_cerrar_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['div_cerrar_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['div_cerrar_contenedor_'.$i])) : '')]) ?>
							</section>
							<hr>
						</section>
					</details>
					<?php if(isset($Web[$Apartado]['cantidad_elementos_contenedor_'.$i]) && !empty($Web[$Apartado]['cantidad_elementos_contenedor_'.$i])): ?>
						<?php for($ii = 1; $ii <= $Web[$Apartado]['cantidad_elementos_contenedor_'.$i]; $ii++): $Web[$Apartado]['elemento'] = $ii; ?>
						<details>
							<summary><?= !empty($template["nombre_elemento_{$ii}_contenedor_{$i}"]) ? (Language(str_replace([" ", "_"], "-", strtolower($template["nombre_elemento_{$ii}_contenedor_{$i}"]))) ?? $template["nombre_elemento_{$ii}_contenedor_{$i}"]) : Language("element") . " #$ii" ?></summary>
							<section class="flex flex-column gap-8" style="background-color: rgba(0,0,0,.1); padding: 8px; border-radius: 4px;">
								<details>
									<summary><?= Language("settings") ?></summary>
									<section class="flex flex-between">
										<?= pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['name'=>"mostrar_elemento_{$ii}_contenedor_{$i}",'title'=>Language('show-or-hide-element')]); ?>
										<?= pInput(['class' => "flex-1", 'placeholder' => Language('item-name'),'title'=>Language('item-name'),'name'=>"nombre_elemento_{$ii}_contenedor_{$i}",'value'=>(isset($Web[$Apartado]["nombre_elemento_{$ii}_contenedor_{$i}"]) ? trim(htmlspecialchars($Web[$Apartado]["nombre_elemento_{$ii}_contenedor_{$i}"])) : '')]); ?>
										<?php $mcpeec = "mostrar_campos_para_el_elemento_{$ii}_contenedor_{$i}";
											$mcpeec_array = !empty($template[$mcpeec]) ? explode(",", $template[$mcpeec]) : [];
											$mcpeec_isset = isset($template[$mcpeec]);

											echo $render_modal_show_fields($mcpeec, $mcplec_array, true, $mcpeec_isset, $mcpeec_array);
										?>
									</section>
								</details>
								<div class="flex flex-column" <?= (!($mcpeec_isset ? in_array("title", $mcpeec_array) : in_array("title", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") ?>>
									<?= pInput(['placeholder'=>Language('title'),'title'=>Language('title'),'name'=>'titulo_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['titulo_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['titulo_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
								</div>
								<div class="flex flex-column" <?= (!($mcpeec_isset ? in_array("content", $mcpeec_array) : in_array("content", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") ?>>
									<?= pTextarea(['placeholder'=>Language('content'),'name'=>'contenido_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['contenido_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['contenido_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : ''),'style'=>'min-height:150px;']) ?>
								</div>
								<section class="flex flex-column gap-4" <?= (!($mcpeec_isset ? in_array("container", $mcpeec_array) : in_array("container", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") ?>>
									<?= pTextarea(['placeholder'=>htmlspecialchars('<div class="">'),'style'=>'width:100%; min-height: 25px;','title'=>Language('open-element-container'),'name'=>'div_abrir_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['div_abrir_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['div_abrir_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
									<?= pTextarea(['placeholder'=>htmlspecialchars('</div>'),'style'=>'width:100%; min-height: 25px;','title'=>Language('close-element-container'),'name'=>'div_cerrar_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['div_cerrar_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['div_cerrar_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
									<label class="flex flex-between">
										<span><?= Language("hidden-tags") ?>:</span>
										<?= pCheckboxBotonActivoDesaptivo($Web, $Apartado, ['invertir' => true, 'name'=>'ocultar_etiquetas_contenedor_campos_default_elemento_'.$ii.'_contenedor_'.$i,'title'=>Language('hide-or-how-the-element-container-tags')]); ?>
									</label>
								</section>
								<div class="flex flex-column" <?= (!($mcpeec_isset ? in_array("styles", $mcpeec_array) : in_array("styles", $mcplec_array)) ? " style=\"display: none;\" hidden" : "")?>>
									<?= pTextarea(['placeholder'=>htmlspecialchars(".boton { color: red; background-color: white; }\n.form { padding: 4px; border-radius: 4px; }\n.check:checked { color: white; box-shadow: 0px 0px 1px 1px #2f9; }"),'style'=>'width:100%; min-height:100px;','title'=>'CSS','name'=>'estilos_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['estilos_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['estilos_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
								</div>
								<details <?= (!($mcpeec_isset ? in_array("commands", $mcpeec_array) : in_array("commands", $mcplec_array)) ? " style=\"display: none;\" hidden" : "")?>>
									<summary><?= Language('add-to-this-form') ?><small> ~ <?= Language('beta') ?></small></summary>
									<section class="flex flex-column">
									<?= pTextarea(['placeholder'=>htmlspecialchars("[Return=PageName]\n[Form=InputModal name=".'""'."]\n[Form=InputModalQuantity name=".'""'."]\n[Form=InputLink name=".'""'."]\n[Return=LinkNew name=".'""'."]\n[Return=LinkNewAll name=".'""'."]\n[Return=LinkNewAllSession name=".'""'."]\n[Return=LinkNewAllNonSession name=".'""'."]\n[Return=Visits]\n[View=components/emojis]\n[Return=CoreVersion]"),'style'=>'width:100%; min-height:150px;','title'=>Language("commands"),'name'=>'comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i,'value'=>(isset($Web[$Apartado]['comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? trim(htmlspecialchars($Web[$Apartado]['comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i])) : '')]) ?>
									</section>
								</details>
								<section class="flex flex-column gap-4" <?= (!($mcpeec_isset ? in_array("scripts", $mcpeec_array) : in_array("scripts", $mcplec_array)) ? " style=\"display: none;\" hidden" : "") ?>>
									<?= isset($Web[$Apartado]['comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i]) && !empty($Web[$Apartado]['comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i]) ? (new Template($Web["template"], $Web))->commands($Web[$Apartado]['comandos_campos_default_elemento_'.$ii.'_contenedor_'.$i], $i, $ii) : '' ?>
								</section>
							</section>
						</details>
						<?php endfor; ?>
					<?php endif; ?>
				</details>
			</section>
		</section>
		<?php endfor; ?>
	<?php endif; ?>
	<section class="panel">
		<section class="form">
		<?= pInput(['type'=>'submit','class'=>'boton','id'=>'procesa_actualizar','name'=>"procesa_$Apartado",'value'=>!empty($show_use_template) ? Language('use') : Language('update')]) ?>
		<hr>
		<?= Daamper::$scripts->xv($Apartado) ?>
		</section>
	</section>
<?php } ?>

<?php
if(!empty($_GET["clasic-template"])) {
	echo clasicTemplate($Apartado, $glob_templates, $render);
} else {
	echo newTemplate($template, $render, $glob_templates, $show_use_template);
}
?>
</form>