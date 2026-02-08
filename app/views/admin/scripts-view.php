<?php
$data = Daamper::$data->Config();
$formAds = function ($section, $allData, $input, $render) use ($Web) {
	$data = $allData[$section] ?? [];

	$content = "<div class=\"flex flex-column gap-12 flex-1\">";

	foreach ([
		["title" => "Google", "placeholder" => "scripts-for-google-analytics-google-fonts-google-adsense", "name" => "google_scripts"],
		["title" => "Font Awesome", "placeholder" => "font-awesome-scripts", "name" => "font_awesome_scripts"],
		["title" => "others", "placeholder" => "use-freely", "name" => "other_scripts"],
	] as $key => $value) {
		// Textarea scripts
		$content .= $input->labelTextarea([
			"label_content" => Language($value["title"]) ?? $value["title"],
			"label_class" => "flex flex-between items-center flex-column-mobil",
			"title" => Language($value["title"]) ?? $value["title"],
			"placeholder" => Language($value["placeholder"]) ?? $value["placeholder"],
			"name" => $value["name"],
			"value" => $data[$value["name"]] ?? "",
			"rows" => 8
		]);
	}

	// Text show
	$content .= "<hr><strong>" . Language("enable") . ":</strong>";

	foreach ([
		["title" => "Google", "name" => "show_google_scripts"],
		["title" => "Font Awesome", "name" => "show_font_awesome_scripts"],
		["title" => "others", "name" => "show_other_scripts"],
	] as $key => $value) {
		// Input enable
		$content .= $input->labelSelect([
			"label_content" => Language($value["title"]) ?? $value["title"],
			"label_class" => "flex flex-between items-center flex-column-mobil",
			"title" => Language($value["title"]) ?? $value["title"],
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
		"title" => "javascript-scripts",
		"checked" => true,
		"content" => $content
	]);
};
?>
<form method="post" action="process/actions.php">
	<?= $formAds("scripts", $data, $input, $render) ?>
</form>
