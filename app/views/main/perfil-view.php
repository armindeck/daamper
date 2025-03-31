<?php if (substr($Web['ruta'], 0, 2) == 'p/'):
	$usuario = str_replace(".php", "", basename($Web['ruta']));
	foreach (usu as $key => $value) {
		if ($usuario == $value['usuario']) { $idUsuario = $value['id']; break; }
	}

	function AlertaMensaje(string $string){
		echo '<div class="con"><p style="text-align: center;">'.$string.'</p></div>';
	}

	if (!isset($idUsuario)) {
		return AlertaMensaje(Language('user-not-exist-value', 'alert', ['value' => $usuario]));
	}
	
	$usuario = usu[$idUsuario];

	if ($usuario['estado'] != 'publico') {
		return AlertaMensaje(Language('user-suspended-deleted', 'alert'));
	}
?>
<section class="perfil">
	<center>
	<?= isset($_SESSION['id']) && $_SESSION['id'] == $idUsuario ? '<a href="'.$Web['directorio'].'auth/configuracion'.$Web['config']['php'].'?up=actualizar_datos_avatar">' : '' ?>
	<img loading="lazy" src="<?= $Web['directorio'] . (file_exists($Web['directorio'].AssetsImg('avatar/'.($usuario['usuario']).'.jpg')) ? AssetsImg('avatar/'.($usuario['usuario']).'.jpg') : AssetsImg('avatar/avatar_default.png')) ?>">
	<?= isset($_SESSION['id']) && $_SESSION['id'] == $idUsuario ? '</a>' : '' ?>
	</center>
	<div class="info">
		<center>
			<p>
				<b><?= $usuario['nombre'] ?></b><br>
				<p class="t-14" style="margin: 6px auto;"><i><?= $usuario['descripcion'] ?? '' ?></i></p>
			</p><br>
			<table border="1">
				<?php
					foreach ([
						Language('user') => 'usuario',
						Language('role') => 'rol',
						Language('social-network') => 'red_social',
						Language('registered') => 'fecha_registrado',
						Language('start-profile') => 'fecha_inicio_sesion'
					] as $key => $value) {
						echo '<tr><td><b>'.$key.':</b></td><td class="t-14">';
						if($value == 'red_social'){
							echo '<a target="_blank" href="'.(isset($usuario[$value.'_enlace']) ? $usuario[$value.'_enlace'] : CONFIG['enlace_web']).'" rel="nofollow">'.(isset($usuario[$value.'_nombre']) ? $usuario[$value.'_nombre'] : CONFIG['nombre_web']).'</a>';
						} else {
							echo $usuario[$value] ?? '';
						}
						echo '</td></tr>';
					}
				?>
			</table>
			<?= isset($_SESSION['id']) && $_SESSION['id'] == $usuario['id'] ? '<div style="margin-top:8px;"><a class="boton-2" href="'.$Web['directorio'].'auth/configuracion'.$Web['config']['php'].'">'.('<i class="fas fa-cog"></i> ').Language('settings').'</a></div>' : '' ?>
		</center>
	</div>
</section>
<?php endif; ?>