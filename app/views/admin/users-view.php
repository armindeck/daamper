<?php
$data = Daamper::$data->UserAll();
$formAds = function ($section, $allData, $input, $render) {
	$content = "<div class=\"flex flex-column gap-4 flex-1\">";

	foreach ($allData as $key => $value){
		$content .= "<details class=\"formulario\"><summary><strong>". $value['nombre'] ."</strong></summary>";
		$content .=	"<hr><ul class=\"flex flex-column\">";
			foreach ($value as $key_value => $value_2) {
				if(!in_array($key_value, ['id', 'contrasena', 'pin'])){
					$content .= "<li class=\"flex-between\">";
						$content .= "<span>". str_replace("_", " ", ucfirst($key_value)) .":</span>";
						$content .= "<span>";
							if (!in_array($key_value, ['rol', 'estado'])){
								$content .= "<p class=\"campo t-14\">". (!is_array($value_2) ? $value_2 : "Array") ."</p>";
							} else {
								$content .= "<select name=\"". $key_value ."-us-". $value['id'] ."\">";
									$lista = $key_value == 'rol' ?
										['Usuario', 'Editor', 'Administrador', 'CEO Founder'] :
										['Publico', 'Suspendido', 'Eliminado'];
									foreach ($lista as $value_3) {
										$content .= "<option " . (strtolower($value_2) == strtolower($value_3) ? 'selected' : '') .">$value_3</option>";
									}
								$content .= "</select>";
							}
						$content .= "</span>";
					$content .= "</li>";
				}
			}
			$content .= "</ul>";
		$content .= "</details>";
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
	<?= $formAds("users", $data, $input, $render) ?>
</form>
