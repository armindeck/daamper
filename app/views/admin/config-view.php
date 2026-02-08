<?php
$data = Daamper::$data->Config();
$formConfig = function ($section, $allData, $input, $render) use ($Web) {
	$data = $allData[$section] ?? [];
	$languages = Daamper::$data->Read('config/language')['global']['languages-options'][(isset($_SESSION['tmp']['language']) ? $_SESSION['tmp']['language'] : Daamper::$config['language'])] ?? [];
	$timezones = Daamper::$data->Read("config/timezone") ?? [];
	// Convert timezones to associative array with key => value (value and value)
	$timezones = !empty($timezones) ? array_combine(array_values($timezones), array_values($timezones)) : [];

	// Get templates
	$glob_templates_files = glob("{$Web['directorio']}assets/css/*.css");
	$glob_templates = [];
	foreach ($glob_templates_files as $template) {
		$base = basename($template); // with extension
		$glob_templates[$base] = trim($base, ".css");
	}

	// Get colors
	$colors_search = Daamper::$scripts->optenerTemas("{$Web['directorio']}assets/css/{$data["theme"]}");
	$colors = [];
	foreach ($colors_search as $color) {
		$base = basename($color); // with extension
		$colors[$base] = $base;
	}

	$content = "<div class=\"flex flex-column gap-4 flex-1\">";

	// Input page name
	$content .= $input->labelText([
		"label_content" => Language("page-name"),
		"label_class" => "flex flex-between items-center flex-column-mobil",
		"title" => Language("page-name"),
		"placeholder" => Language("page-name"),
		"name" => "nombre_web",
		"value" => $data['nombre_web'] ?? "",
	]);

	// Input page link
	$content .= $input->labelText([
		"label_content" => Language("page-link"),
		"label_class" => "flex flex-between items-center flex-column-mobil",
		"title" => Language("page-link"),
		"placeholder" => Language("page-link"),
		"name" => "enlace_web",
		"type" => "url",
		"value" => $data['enlace_web'] ?? ""
	]);

	// Input selected timezone
	$content .= $input->labelSelect([
		"label_content" => Language("time-zone"),
		"label_class" => "flex flex-between items-center flex-column-mobil",
		"title" => Language("time-zone"),
		"name" => "timezone",
		"selected" => $data['timezone'] ?? "",
		"option" => $timezones ?? [],
	]);

	// Input year of page publication
	$content .= $input->labelText([
		"label_content" => Language("year-of-page-publication"),
		"label_class" => "flex flex-between items-center flex-column-mobil",
		"title" => Language("year-of-page-publication"),
		"placeholder" => Language("year-of-page-publication"),
		"name" => "ano_publicada",
		"type" => "number",
		"min" => 1969,
		"value" => $data['ano_publicada'] ?? ""
	]);

	// Input selected language
	$content .= $input->labelSelect([
		"label_content" => Language("language"),
		"label_class" => "flex flex-between items-center flex-column-mobil",
		"title" => Language("language"),
		"name" => "language",
		"selected" => $data['language'] ?? "",
		"option" => $languages ?? [],
	]);

	// Input selected template
	$content .= $input->labelSelect([
		"label_content" => Language("theme"),
		"label_class" => "flex flex-between items-center flex-column-mobil",
		"title" => Language("theme"),
		"name" => "theme",
		"selected" => $data['theme'] ?? "",
		"option" => $glob_templates ?? [],
	]);

	// Input selected color
	$content .= $input->labelSelect([
		"label_content" => Language("default-color"),
		"label_class" => "flex flex-between items-center flex-column-mobil",
		"title" => Language("default-color"),
		"name" => "color",
		"selected" => $data['color'] ?? "",
		"option" => $colors ?? [],
	]);

	$content .= "<hr>";

	// Input enable https image
	$content .= $input->labelSelect([
		"label_content" => Language("use-internal-image"),
		"label_class" => "flex flex-between items-center flex-column-mobil",
		"title" => Language("use-internal-image"),
		"name" => "https_imagen",
		"selected" => !empty($data['https_imagen']) && $data['https_imagen'] == $data["enlace_web"] . '/' ? 1 : 0,
		"option" => [
			"" => Language("no"),
			1 => Language("yes"),
		],
	]);

	// Input enable php extension
	$content .= $input->labelSelect([
		"label_content" => Language("use-internal-php-extension"),
		"label_class" => "flex flex-between items-center flex-column-mobil",
		"title" => Language("use-internal-php-extension"),
		"name" => "php",
		"type" => "checkbox",
		"selected" => !empty($data['php']) ? true : false,
		"option" => [
			"" => Language("no"),
			1 => Language("yes"),
		],
	]);

	// Input show errors
	$content .= $input->labelSelect([
		"label_content" => Language("show-errors"),
		"label_class" => "flex flex-between items-center flex-column-mobil",
		"title" => Language("show-errors"),
		"name" => "errores",
		"type" => "checkbox",
		"selected" => !empty($data['errores']) ? true : false,
		"option" => [
			"" => Language("no"),
			1 => Language("yes"),
		],
	]);

	$content .= "<hr>";

	// Input submit
	$content .= $input->submit([
		"class" => "boton",
		"name" => "procesa_" . $section,
		"value" => Language("update"),
	]);

	$content .= "<hr>";

	// Scripts version
	$content .= Daamper::$scripts->xv($section);

	$content .= "</div>";

	// Print
	return $render->dropdown([
		"id" => "form-config",
		"title" => "settings",
		"checked" => true,
		"content" => $content
	]);
};

$formHtaccess = function ($section, $allData, $input, $render) {
	$data = $allData[$section] ?? [];
	$lista_errores = [
		400 => "bad-request",
		401 => "unauthorized",
		403 => "forbidden",
		404 => "not-found",
		500 => "internal-server-error",
		503 => "service-unavailable"
	];

	$enable_list = ['todo_https' => 'ssl-https', 'errores' => 'errors', 'timezone' => 'time-zone'];

	$content = "<div class=\"flex flex-column gap-4 flex-1\">";

	foreach ($lista_errores as $key => $value) {
		// Input links
		$content .= $input->labelText([
			"label_content" => $key . " - " . Language($value),
			"label_class" => "flex flex-between items-center flex-column-mobil",
			"title" => Language($value),
			"placeholder" => "https://.com/{$key}",
			"name" => "error_{$key}",
			"value" => $data["error_{$key}"] ?? "",
			"required" => true,
			"type" => "url"
		]);
	}

	$content .= "<hr>";

	foreach ($enable_list as $key => $value) {
		// Input enable
		$content .= $input->labelSelect([
			"label_content" => Language($value),
			"label_class" => "flex flex-between items-center flex-column-mobil",
			"title" => Language($value),
			"name" => $key,
			"selected" => !empty($data[$key]) ? true : false,
			"option" => [
				"" => Language("no"),
				1 => Language("yes"),
			],
		]);
	}

	$content .= "<hr>";

	// Input submit
	$content .= $input->submit([
		"class" => "boton",
		"name" => "procesa_" . $section,
		"value" => Language("update"),
	]);

	$content .= "<hr>";

	// Scripts version
	$content .= Daamper::$scripts->xv($section);

	$content .= "</div>";

	// Print
	return $render->dropdown([
		"id" => "form-htaccess",
		"title" => "htaccess",
		"checked" => false,
		"content" => $content
	]);
};
?>

<form method="post" action="process/actions.php">
	<?= $formConfig("config", $data, $input, $render) ?>
</form>
<form method="post" action="process/actions.php">
	<?= $formHtaccess("htaccess", $data, $input, $render) ?>
</form>
