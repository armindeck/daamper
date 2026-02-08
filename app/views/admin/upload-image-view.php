<?php
$formUploadImage = function ($section, $allData, $input, $render) {
	$data = $allData[$section] ?? [];
	$lista_inputs = [
		["type" => "file", "class" => "boton-2", "name" => "imagen", "required" => true, "label_content" => Language(['upload-image', 'select-image'], 'dashboard')],
		["type" => "text", "name" => "imagen_nombre", "required" => false, "label_content" => Language('name') . ' ('.Language('optional').')']
	];

	$content = "<div class=\"flex flex-column gap-4 flex-1\">";
	$content .= "<p>". Language(['upload-image', 'recommended'], 'dashboard', ['value' => '<a target="_blank" rel="nofollow" href="https://tinypng.com/">TinyPNG</a>']) ."</p><hr>";

	foreach ($lista_inputs as $key => $value) {
		// Input links
		$content .= $input->labelText(array_merge($value, [
			"label_class" => "flex flex-between items-center flex-column-mobil",
			"title" => $value['label_content'],
			"placeholder" => Language(['upload-image', 'image-name'], 'dashboard'),
		]));
	}

	$content .= "<hr>";

	// Input submit
	$content .= $input->submit([
		"class" => "boton",
		"name" => "procesa_" . $section,
		"value" => Language("upload-image"),
	]);

	$content .= "<hr>";

	// Scripts version
	$content .= Daamper::$scripts->xv($section);

	$content .= "</div>";

	// Print
	return $render->dropdown([
		"id" => "form-upload-image",
		"title" => "upload-image",
		"checked" => true,
		"content" => $content
	]);
};
?>

<form method="post" action="process/actions.php" enctype="multipart/form-data">
	<?= $formUploadImage("upload-image", [], $input, $render) ?>
</form>