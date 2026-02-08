<?php $Section = "directory";

$parent_directory = $Web["directorio"];
$get_route = (!empty($_GET["dir"]) ? str_replace(["../", "./"], "", htmlspecialchars($_GET["dir"])) : "");
$get_route .= strlen($get_route) > 0 ? ($get_route[-1] != "/" ? "/" : "") : "";
$route = $parent_directory . $get_route;
$routeSearch = str_replace(["../", "./"], "", $route);
$directorySearch = Daamper::$scripts->ReadDirectory($routeSearch ?? "", ["type" => true]);

$explode_get_route = explode("/", $get_route); // Convertir en array la lista
$count_explode_get_route = count($explode_get_route) - 1; // Contar la ruta
unset($explode_get_route[$count_explode_get_route]); // Eliminar la ultima ruta que esta vacia

$back_route = $explode_get_route; // Agregar el explode a back route
unset($back_route[count($back_route)-1]); // Eliminar la ultima ruta
$back_route = !empty($count_explode_get_route) ? $parent_directory . (count($back_route) > 0 ? ((implode("/", $back_route)) . "/") : "") : ""; // Back route

// Images
$support_image = [];
foreach (Daamper::$data->Config("default")["global"]["upload-image"]["support"] as $key => $value) {
	$support_image[] = str_replace("image/", "", $value);
}

$content = "";
$folder = [];
$files = [];
$images = [];

foreach($directorySearch as $key => $file){
	if($file["type"] == "folder"){ $folder[$key] = $file[0]; } else {
		if(in_array($file["type"], $support_image)){
			$images[$key] = $file[0];
		} else {
			$files[$key] = $file[0];
		}
	}
}

$count = count($folder) + count($files);

$back_button = !empty($back_route) ? "<a class=\"boton-2\" href=\"?ap=directory&dir={$back_route}\" style=\"padding: 4px 6px; font-size: small;\"><i class=\"fas fa-arrow-left\"></i></a>" : "";

// Campo de ruta
$content .= <<<HTML
	<style>.show-list + form + section.form { display: none; } .show-list:checked + form + section.form { display: flex; }</style>
	<input type="checkbox" class="show-list" id="show-list" hidden>
	<form method="get" class="flex flex-between gap-4" style="margin-bottom: 8px;">
		<input type="hidden" name="ap" value="directory" required hidden>
		$back_button		
		<label class="flex flex-between gap-4 items-center flex-1">
			<input name="dir" type="text" value="$route" class="flex-1" style="padding: 4px 6px; font-size: small;" required>
			<button style="padding: 4px 6px;" type="submit" class="boton-2 t-small"><i class="fas fa-search"></i></button>
		</label>
		<label for="show-list" class="boton-2 t-small" style="padding: 4px 6px;"><i class="fas fa-list"></i></label>
	</form>
HTML;

$translate_filename = Language("file-name");
$translate_foldername = Language("folder-name");
$translate_newfile = Language("new-file");
$translate_newfolder = Language("new-folder");
$translate_delete_folder = Language("delete-folder");
$translate_no = Language("no");
$translate_yes = Language("yes");

// Campo de crear archivo
$field_create = <<<HTML
	<section class="form flex flex-column gap-8">
		<form method="post" class="flex flex-column gap-4" title="$translate_newfile">
			<label class="flex flex-between gap-4 items-center flex-1">
				<a class="boton-2" style="padding: 4px 6px; font-size: small;"><i class="fas fa-file-medical"></i></a>
				<input name="archivo" type="text" class="flex-1" style="padding: 4px 6px; font-size: small;" placeholder="$translate_filename" pattern="[a-zA-Z0-9_-.]+" minlength="1" required>
				<button style="padding: 4px 6px;" type="submit" name="crear_archivo_boton" value="true" class="boton-2 t-small"><i class="fas fa-plus"></i></button>
			</label>
		</form>
		<form method="post" class="flex flex-column gap-4" title="$translate_newfolder">
			<label class="flex flex-between gap-4 items-center flex-1">
				<a class="boton-2" style="padding: 4px 6px; font-size: small;"><i class="fas fa-folder-plus"></i></a>
				<input name="carpeta" type="text" class="flex-1" style="padding: 4px 6px; font-size: small;" placeholder="$translate_foldername" pattern="[a-zA-Z0-9_-.]+" minlength="1" required>
				<button style="padding: 4px 6px;" type="submit" name="crear_carpeta_boton" value="true" class="boton-2 t-small"><i class="fas fa-plus"></i></button>
			</label>
		</form>
		<form method="post" class="flex flex-column gap-4" style="margin-bottom: 8px;" title="$translate_delete_folder">
			<label class="flex flex-between gap-4 items-center flex-1">
				<a class="boton-2" style="padding: 4px 6px; font-size: small;"><i class="fas fa-folder-minus"></i></a>
				<select name="confirmar" class="flex-1" style="padding: 4px 6px; font-size: small;" required>
					<option value="">$translate_delete_folder</option>
					<option value="No">$translate_no</option>
					<option value="Si">$translate_yes</option>
				</select>
				<button style="padding: 4px 6px;" type="submit" name="eliminar_carpeta_boton" value="true" class="boton-2 t-small"><i class="fas fa-trash"></i></button>
			</label>
		</form>
	</section>
HTML;

$content .= $field_create;

$all = array_merge($folder, $files);
$divi = false;

$all_type = "";
foreach($all as $key => $value){
	if($directorySearch[$key]["type"] == "folder" && $all_type != $directorySearch[$key]["type"]){
		$content .= "<small style=\"margin-bottom: 8px;\">" . Language("directories") . "</small>";
		$all_type = $directorySearch[$key]["type"];
	}
	if(count($folder) && count($files) && isset($files[$key]) && !$divi){
		$content .= "<hr>";
		$content .= "<small style=\"margin-bottom: 8px;\">" . Language("files") . "</small>";
		$divi = true;
	}

	$icon = $directorySearch[$key]["type"] == "folder" ? "folder" : "file-code";
	$nueva_ruta = $directorySearch[$key]["type"] == "folder" ? "directory" : "editor";
	$target = $directorySearch[$key]["type"] == "folder" ? "" : "target=\"_blank\"";

	$content .= <<<HTML
		<a class="boton-3" href="?ap={$nueva_ruta}&dir={$parent_directory}{$key}" {$target}>
			<span class="icon icon--left"><i class="fas fa-{$icon}"></i></span>
			<span class="text">$value</span>
		</a>
	HTML;
}

$language_details = Language("details");
$image_content = "";
foreach ($images as $key => $value) {
	$image_content .= <<<HTML
		<div class="flex flex-column gap-4 w-100p max-w-150">
			<a href="{$parent_directory}{$key}" class="w-100p flex flex-evenly" target="_blank">
				<img class="w-100p" src="{$parent_directory}{$key}" loading="lazy">
			</a>
			<a class="boton-3" style="padding: 4px 6px; font-size: small;" target="_blank" href="?ap=editor&dir={$parent_directory}{$key}"><span class="icon icon--left"><i class="fas fa-edit"></i></span><span class="text">$language_details</span></a>
		</div>
	HTML;
}

// Images
$content .= count($all) && count($images) ? "<hr><small style=\"margin-bottom: 8px;\">" . Language("images") . "</small>" : "";

$extruct_image_content = <<<HTML
	<div class="flex flex-evenly gap-8 items-start">
		$image_content
	</div>
HTML;

$content .= count($images) ? $extruct_image_content : "";

$content .= "<hr><div class=\"flex flex-between gap-1\"><small><i class=\"fas fa-folder\"></i> ". (count($folder)) ."<span style=\"margin-right: 8px;\"></span> <i class=\"fas fa-file-code\"></i> ". (count($files))."<span style=\"margin-right: 8px;\"></span> <i class=\"fas fa-image\"></i> ". (count($images)) ."</small><small>" . Daamper::$scripts->xv($Section) ."</small></div>";

?>

<?= $render->dropdown([
	"id" => "form-file-explorer",
	"title" => "file-explorer",
	"checked" => true,
	"content" => "<div class=\"flex flex-column\">" . ($content) . "</div>"
]); ?>
