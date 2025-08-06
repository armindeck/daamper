<?php /* 04/01/2025 | 11/03/2025 | 15/05/2025 */ ?>
<section class="panel">
	<div class="form">
		<strong><?= Language('information') ?></strong><hr>
		<p><?= Language(['info', 'about'], 'dashboard') ?></p>
		<?php function Version (array $list = ["dashboard", "creator", "other", "normal"]) {
			$show = [];
			if($list){
				$count = count($list);
				if($count == 1) { $show = Daamper::$version[$list[0]]; }
				if($count == 2) { $show = Daamper::$version[$list[0]][$list[1]]; }
				if($count == 3) { $show = Daamper::$version[$list[0]][$list[1]][$list[2]]; }
				if($count == 4) { $show = Daamper::$version[$list[0]][$list[1]][$list[2]][$list[3]]; }
			}
			$return = '';
			foreach (['version', 'state', 'updated', 'created'] as $v) {
				$return .= $show[$v] ? ($v == 'created' ? '- ' : '') . ($v == "state" ? Language($show["state"] == "Estable" ? "stable" : strtolower($show["state"])) : $show[$v]) . ' ' : '';
			}
			return $return ?? '';
		} ?>
		<?php foreach (['system', 'language', 'dashboard', 'other', 'components', 'social-networks'] as $opcion): ?>
		<details open>
			<summary><?= Language($opcion) ?><?= $opcion == 'social-networks' ? ' <i class="fas fa-external-link-alt"></i>' : '' ?></summary>
			<section>
				<ul>
					<?php if ($opcion == 'system') {
						foreach (['creator' => 'author-and-page-name', 'project' => 'page-name', 'version' => 'version', 'state' => 'state', 'updated' => 'updated', 'created' => 'created', 'license' => 'license'] as $sistema => $valor) {
							echo '<li class="flex-between boton-2 boton-mini"><span>'. (Language($sistema)) . ':</span> '. ($valor == "state" ? (Language(Daamper::$infoversion[$valor] == "Estable" ? "stable" : strtolower(Daamper::$infoversion[$valor]))) : Daamper::$infoversion[$valor]) .'</li>';
						}
					} ?>
					<?= $opcion == "language" ? '<li class="flex-between boton-2 boton-mini"><span>'. (Language("language")) . ':</span> '. Version(["language"]) .'</li>' : ""; ?>
					<?php if (in_array($opcion, ['dashboard', 'other', 'components'])) { $lista = Daamper::$data->Read("config/version")[$opcion] ?? [];
						foreach ($lista as $key => $value) {
							echo '<li class="flex-between boton-2 boton-mini"><span>' . Language($key) . ':</span> ';
							echo Version([$opcion, $key]);
							echo '</li>';
							if (in_array($key, ['creator'])) {
								echo '<li class="flex-between boton-2 boton-mini" style="margin-left: 16px;"><span>' . Language("preview") . ':</span> ';
								echo Version(["dashboard", "creator", "preview"]);
								echo '</li>';
								echo '<details style="margin-left: 16px;" open><summary>'.(Language('creators')).'</summary><section class="flex-column" style="gap: 0px;">';
								foreach ($lista["creator"]["other"] as $key2 => $value2) {
									$title = match (true) {
										$key2 == "anime_entrada" => "anime-entry",
										$key2 == "anime_mirando" => "anime-watching",
										$key2 == "juego" => "game",
										default => $key2
									};
									echo '<li class="flex-between boton-2 boton-mini"><span>' . Language($title) . ':</span> ';
									echo Version(["dashboard", "creator", "other", $key2]);
									echo '</li>';
								}
								echo '</section></details>';
							}
						}
					} ?>
					<?php if ($opcion == 'social-networks') {
						foreach (Daamper::$info['social-networks'] as $red => $valor) {
							echo '<a class="flex-between boton-2 boton-mini" href="'.$valor['link'].'" target="_blank"><span>' . $red . ':</span> <span>'.$valor['name'].'</span></a>';
						}
					} ?>
				</ul>
			</section>
		</details>
		<?php endforeach; ?>
		<small class="t-center" style="margin-top: 15px;">&copy; <?= Daamper::$info['anio'] ?> - <?= Daamper::$scripts->anio(); ?> <?= Daamper::$info['author-and-page-name'] ?>.</small>
	</div>
</section>