<?php
$file = Daamper::$scripts->normalizar2($_GET["dir"] . ($_GET["crear"] ?? ""));
$file_exists = file_exists($file);
$file_content = $file_exists ? file_get_contents($file) : "";
$file_type = "text";

$data = [
	"file_name" => $file,
	"file_content" => $file_content,
	"file_exists" => $file_exists,
	"file_type" => $file_type
];

$formEditor = function ($section, $allData, $input, $render) use ($Web, $data) {
	$data = $allData;
	$content = "<div class=\"flex flex-column gap-4\">";

	$content .= "<form method=\"post\" class=\"flex flex-column gap-4 flex-1\">";

	// Input file name
	$content .= $input->text([
		"title" => Language("file-name"),
		"placeholder" => "file.txt",
		"name" => "file_name",
		"value" => $data["file_name"] ?? "",
		"type" => "text",
		"disabled" => true,
		"required" => true,
	]);
	
	$image_list = Daamper::$data->Config("default")["global"]["upload-image"]["support"];
	$images = array_map(function ($image){
		return str_replace("image/", "", $image);
	}, $image_list);
	$is_image = in_array(pathinfo(basename($data["file_name"]), PATHINFO_EXTENSION), $images);
	
	$content .= $is_image ? "<center>".
		"<a href=\"" . ($data["file_name"]) . "\" target=\"_blank\">".
			"<img src=\"" . ($data["file_name"]) . "\" style=\"width: fit-content; max-width: 100%;\" loading=\"lazy\">".
		"</a>".
	"</center>" : "";

	// Textarea file content
	$content .= !$is_image ? $input->textarea([
		"title" => Language("content"),
		"placeholder" => Language("content"),
		"name" => "file_content",
		"value" => $data['file_content'] ?? "",
		"rows" => 22,
		"required" => true,
	]) : "";

	$content .= !$is_image ? $render->modal([
		"id" => "modal-create-or-edit-file",
		"title" => Language($data["file_exists"] ? "update" : "create"),
		"class" => "flex-1",
		"content" => $input->select([
			"title" => Language($data["file_exists"] ? "confirm-edit-file" : "confirm-create-file"),
			"name" => "confirm_create_or_edit_file",
			"option" => [
				"" => Language($data["file_exists"] ? "confirm-edit-file" : "confirm-create-file"),
				1 => Language("yes"),
			],
			"required" => true,
		]) . $input->submit([
			"class" => "boton-2 t-small t-center",
			"name" => "submit_create_or_edit_file",
			"value" => Language($data["file_exists"] ? "update" : "create"),
		]),
	]) : "";

	$content .= "</form>";

	$content .= "<form method=\"post\">";

	$content .= $render->modal([
		"id" => "modal-delete-file",
		"title" => Language("delete"),
		"content" => $input->select([
			"title" => Language("confirm-delete-file"),
			"name" => "confirm_delete_file",
			"option" => [
				"" => Language("confirm-delete-file"),
				1 => Language("yes"),
			],
			"required" => true,
		]) . $input->submit([
			"class" => "boton-2 t-small t-center",
			"name" => "submit_delete_file",
			"value" => Language("delete-file"),
		]),
	]);

	$content .= "</form>";

	$content .= "<div class=\"t-center\" style=\"padding: 12px 8px;\">";

	// Scripts version
	$content .= Daamper::$scripts->xv($section);

	$content .= "</div></div>";

	// Print
	return $render->dropdown([
		"id" => "form-editor",
		"title" => $section,
		"checked" => true,
		"content" => $content
	]);
};
?>

<?= $formEditor("editor", $data, $input, $render) ?>