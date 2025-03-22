<?php /* 04/01/2025 | 11/03/2025 */ ?>
<section class="panel">
	<div class="form">
		<strong><?= LANGUAJE['global']['information'][CONFIG['languaje']] ?></strong><hr>
		<p><?= LANGUAJE['dashboard']['info']['about'][CONFIG['languaje']] ?></p>
		<?php function Versiones (string $ruta, string $other = null) {
			$ruta = basename($ruta); if ($other) { $other = basename($other); }
			$return = '';
			$rut = $other !== null ? VERSION['dashboard'][$ruta]['other'][$other] : VERSION['dashboard'][$ruta];
			foreach (['version', 'state', 'updated', 'created'] as $x) {
				$return .= $rut[$x] ? ($x == 'created' ? '- ' : '') . $rut[$x]. ' ' : '';
			}
			return $return ?? '';
		} ?>
		<?php foreach (['system', 'dashboard', 'social-networks'] as $opcion): ?>
		<details open>
			<summary><?= LANGUAJE['global'][$opcion][CONFIG['languaje']] ?><?= $opcion == 'social-networks' ? ' <i class="fas fa-external-link-alt"></i>' : '' ?></summary>
			<section>
				<ul>
					<?php if ($opcion == 'system') {
						foreach (['creator' => 'author', 'project' => 'author-page-name', 'website-name' => 'page-name', 'version' => 'version', 'state' => 'state', 'updated' => 'updated', 'created' => 'created', 'license' => 'license'] as $sistema => $valor) {
							echo '<li class="flex-between boton-2 boton-mini"><span>'. (LANGUAJE['global'][$sistema][CONFIG['languaje']]) . ':</span> '. INFOVERSION[$valor] .'</li>';
						}
					} ?>
					<?php if ($opcion == 'dashboard') { $lista = glob('app/*');
						foreach ($lista as $key => $value) {
							if (!in_array(basename($value), ['actualizaciones'])) {
								echo '<li class="flex-between boton-2 boton-mini"><span>' . ucfirst(basename($value)) . ':</span> ';
								echo Versiones($value);
								echo '</li>';
								if (basename($value) == 'creador') {
									echo '<details style="margin-left: 16px;" open><summary>'.(LANGUAJE['global']['creators'][CONFIG['languaje']]).'</summary><section class="flex-column" style="gap: 0px;">';
									$lista2 = glob('app/creador/creadores/*');
									foreach ($lista2 as $key2 => $value2) {
										echo '<li class="flex-between boton-2 boton-mini"><span>' . ucfirst(basename($value2)) . ':</span> ';
										echo Versiones($value, $value2) ?? 'undefined';
										echo '</li>';
									}
									echo '</section></details>';
								}
							}
						}
					} ?>
					<?php if ($opcion == 'social-networks') {
						foreach (INFO['social-networks'] as $red => $valor) {
							echo '<a class="flex-between boton-2 boton-mini" href="'.$valor['link'].'" target="_blank"><span>' . $red . ':</span> <span>'.$valor['name'].'</span></a>';
						}
					} ?>
				</ul>
			</section>
		</details>
		<?php endforeach; ?>
		<small class="t-center" style="margin-top: 15px;">&copy; <?= INFO['anio'] ?> <?= INFO['author'] ?> / <?= INFO['author-page-name'] ?>.</small>
	</div>
</section>