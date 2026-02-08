<?php
$data = Daamper::$data->Config();
$formAds = function ($section, $allData, $input, $render) use ($Web) {
	$data = $allData[$section] ?? [];

	$content = "<div class=\"flex flex-column gap-4 flex-1\">";

	// Message
	$content .= "<p>" . Language("update-messages-and-announcements") . "<p><hr>";

	// Files accept
	$support = Daamper::$data->Read("config/default")["admin"]["upload-image"]["support"] ?? [];
	$accept  = implode(",", $support); // Array to string
	$accept  = str_replace("image/", "", $accept); // Replace

	// Search images
	$images = Daamper::$scripts->readDirectory("assets/img/", ["files" => $accept ?? "", "show" => "route|basename", "extension" => "true|true"]);

	// Text links
	$content .= "<strong>" . Language("links") . ":</strong>";

	foreach ([
		["title" => "moving-message", "name" => "enlace_anuncio_mensaje_movimiento"],
		["title" => "long-image", "name" => "enlace_anuncio_mini_banner"],
		["title" => "aside-thumbnail", "name" => "enlace_anuncio_miniatura_article"],
	] as $key => $value) {
		// Input links
		$content .= $input->labelText([
			"label_content" => Language($value["title"]),
			"label_class" => "flex flex-between items-center flex-column-mobil",
			"title" => Language($value["title"]),
			"placeholder" => "https://.com",
			"name" => $value["name"],
			"value" => $data[$value["name"]] ?? "",
			"type" => "url",
		]);
	}

	// Text images
	$content .= "<hr><strong>" . Language("images") . ":</strong>";

	foreach ([
		["title" => "long-image", "name" => "imagen_anuncio_mini_banner"],
		["title" => "aside-thumbnail", "name" => "imagen_anuncio_miniatura_article"],
	] as $key => $value) {
		// Input selected images
		$content .= $input->labelSelect([
			"label_content" => Language($value["title"]),
			"label_class" => "flex flex-between items-center flex-column-mobil",
			"title" => Language($value["title"]),
			"name" => $value["name"],
			"selected" => $data[$value["name"]] ?? "",
			"option" => $images ?? [],
		]);
	}

	// Text images
	$content .= "<hr><strong>" . Language("moving-message") . ":</strong>";

	// Textarea moving message
	$content .= $input->textarea([
		"title" => Language("moving-message"),
		"placeholder" => Language("moving-message"),
		"name" => "anuncio_mensaje_movimiento_texto",
		"value" => $data['anuncio_mensaje_movimiento_texto'] ?? "",
		"rows" => 4
	]);

	// Text show
	$content .= "<hr><strong>" . Language("show") . ":</strong>";

	foreach ([
		["title" => "moving-message", "name" => "mostrar_anuncio_mensaje_movimiento"],
		["title" => "long-image", "name" => "mostrar_anuncio_mini_banner"],
		["title" => "aside-thumbnail", "name" => "mostrar_anuncio_miniatura_article"],
	] as $key => $value) {
		// Input enable
		$content .= $input->labelSelect([
			"label_content" => Language($value["title"]),
			"label_class" => "flex flex-between items-center flex-column-mobil",
			"title" => Language($value["title"]),
			"name" => $value["name"],
			"selected" => !empty($data[$value["name"]]) ? 1 : 0,
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
		"id" => "form-config",
		"title" => $section,
		"checked" => true,
		"content" => $content
	]);
};
?>
<form method="post" action="process/actions.php">
	<?= $formAds("ads", $data, $input, $render) ?>
</form>
