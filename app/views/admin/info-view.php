<div class="flex flex-column gap-12">
<?php foreach (['about', 'core', 'license', 'dashboard', 'other', 'social-networks'] as $opcion):
	$content = "";

	if($opcion == "about"){ $content = "<small>" .(Language(['info', 'about'], 'dashboard')) . "</small>"; }

	if($opcion == "license"){
		$content = "<p class=\"t-small\">" . nl2br(htmlspecialchars(file_exists(RAIZ . "LICENSE.txt") ? file_get_contents(RAIZ . "LICENSE.txt") : (Language("license-extra", "core")))) . "</p>";
	}

	if ($opcion == 'core') {
		foreach (['creator' => 'author-and-page-name', 'name' => 'page-name', 'version' => 'version', 'state' => 'state', 'updated' => 'updated', 'created' => 'created'] as $core => $valor) {
			$content .= "<a class=\"boton-3\"><div class=\"flex flex-between t-small\"><span>" . (Language($core)) . ":</span> <span>" .
				($valor == "state" ? (Language(strtolower(Daamper::$infoversion[$valor]))) : Daamper::$infoversion[$valor]) .
				"</span></div></a>";
		}
	}
	
	if (in_array($opcion, ['dashboard', 'other', 'components'])) { $lista = Daamper::$data->Read("config/version")[$opcion] ?? [];
		foreach ($lista as $key => $value) {
			$content .= "<a class=\"boton-3\"><div class=\"flex flex-between t-small\"><span>" . (Language($key)) . ":</span> <span>" . Daamper::$scripts->version([$opcion, $key]) . "</span></div></a>";
		}
	}

	if ($opcion == 'social-networks') {
		foreach (Daamper::$info['social-networks'] as $red => $valor) {
			$content .= "<a class=\"boton-3 flex flex-between t-small\" href=\"{$valor["link"]}\" target=\"_blank\"><span>{$red}:</span> <span>{$valor['name']}</span></a>";
		}
	}

	echo $render->dropdown([
		"id" => "info-container-{$opcion}",
		"title" => $opcion,
		"checked" => true,
		"content" => "<nav class=\"flex flex-column\">". ($content ?? "") ."</nav>"
	]);
endforeach; ?>

<p class="mr-y-16 t-center"><small class="t-center" style="margin-top: 15px;">&copy; <?= Daamper::$info['anio'] ?> - <?= Daamper::$scripts->anio(); ?> <?= Daamper::$info['author-and-page-name'] ?>.</small></p>
</div>