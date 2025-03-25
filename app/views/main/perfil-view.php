<?php if(substr($Web['ruta'], 0, 2) == 'p/') : ?>
<?php foreach (usu as $key => $value) {
	if($value['usuario'] == SCRIPTS->quitarEPHP(basename($Web['ruta']))){
		$Perfil['id']=$value['id'];
		$Perfil['usuario']=$value['usuario'];
		$Perfil['nombre']=$value['nombre'];
		$Perfil['estado']=$value['estado'];
		$Perfil['avatar'] = file_exists($Web['directorio'].AssetsImg('avatar/'.$Perfil['usuario'].'.jpg')) ? AssetsImg('avatar/'.$Perfil['usuario'].'.jpg') : AssetsImg('avatar/avatar_default.png');
		$Perfil['descripcion'] = isset($value['descripcion']) ? $value['descripcion'] : 'Descripción default';
		$Perfil['rol']=$value['rol'];
		$Perfil['red_social_nombre'] = isset($value['red_social_nombre']) ? $value['red_social_nombre'] : 'dbproject';
		$Perfil['red_social_enlace'] = isset($value['red_social_enlace']) ? $value['red_social_enlace'] : 'https://dbproject.rf.gd';
		$Perfil['fecha_inicio_sesion'] = isset($value['fecha_inicio_sesion']) ? $value['fecha_inicio_sesion'] : '';
		$Perfil['fecha_registrado']=$value['fecha_registrado'];
		break;
	}
}
?>
<?php if($Perfil['estado'] == 'publico'){ ?>
	<div class="perfil">
		<?php if(isset($_SESSION['id']) && $_SESSION['id'] == $Perfil['id']): echo '<a href="'.$Web['directorio'].'auth/configuracion'.$Web['config']['php'].'?up=actualizar_datos_avatar">'; endif; ?>
		<img loading="lazy" src="<?php echo $Web['directorio'] . $Perfil['avatar']; ?>">
		<?php if(isset($_SESSION['id']) && $_SESSION['id'] == $Perfil['id']): echo '</a>'; endif; ?>
		<div class="info">
			<center>
				<p>
					<b><?php echo $Perfil['nombre']; ?></b><br>
					<p class="t-14"><?php echo $Perfil['descripcion']; ?></p>
				</p><br>
				<table border="1">
					<?php
						$list_perfil = ['Usuario'=>'usuario','Rol'=>'rol','Red social'=>'red_social','Registrado'=>'fecha_registrado','Inicio'=>'fecha_inicio_sesion'];
						foreach ($list_perfil as $key => $value) {
							echo '<tr><td><b>'.$key.':</b></td><td class="t-14">';
							if($value=='red_social'){
								echo '<a target="_blank" href="'.$Perfil[$value.'_enlace'].'" rel="nofollow">'.$Perfil[$value.'_nombre'].'</a>';
							}
							else {
								echo $Perfil[$value];
							}
							
							echo '</td></tr>';
						}
					?>
				</table>
				<?= isset($_SESSION['id']) && $_SESSION['id'] == $Perfil['id'] ? '<div style="margin-top:8px;"><a href="'.$Web['directorio'].'auth/configuracion'.$Web['config']['php'].'">Configuración</a></div>' : '' ?>
			</center>
		</div>
	</div>
<?php } else { ?>
	<div class="con"><p style="text-align: center;">Este perfil esta suspendido o fue eliminado.</p></div>
<?php } ?>
<?php endif; ?>