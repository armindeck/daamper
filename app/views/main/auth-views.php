<?php #FORMULARIO DE INICIAR, REGISTRAR, OLVIDE CONTRASENA, CAMBIAR CONTRASEÑA, MODIFICAR DATOS
if($Web['ruta_completa'] == '../auth/iniciar.php' || $Web['ruta_completa'] == '../auth/registrar.php' || $Web['ruta_completa'] == '../auth/olvide-contrasena.php' || $Web['ruta_completa'] == '../auth/cambiar-contrasena.php' || $Web['ruta_completa'] == '../auth/configuracion.php'){ ?>
	<div style="display: flex; flex-wrap: wrap; justify-content: center; margin: 20px 0px;">
	<style type="text/css">.auth label { display:flex; flex-wrap:wrap; flex-direction: column; justify-content:space-between; gap: 4px; }</style>
	<form class="formulario flex-column auth" style="gap: 4px; width: 100%; margin: 0px 4px; max-width: 640px;" method="post" action="<?php echo $Web['directorio']; ?>procesa/procesa.auth.php" <?php if($Web['ruta_completa']=='../auth/configuracion.php' && isset($_GET['up']) && $_GET['up']=='actualizar_datos_avatar'){ echo 'enctype="multipart/form-data"'; } ?>>
		<?php if($Web['ruta_completa'] == '../auth/iniciar.php'): ?>
		<b>Iniciar sesión</b><hr>
		<?php
		echo pInput(['name'=>'usuario','placeholder'=>'Usuario','pattern'=>'[a-zA-Z0-9]+','minlength'=>4,'maxlength'=>20,'label'=>true,'texto'=>'Usuario','required'=>true]).
		pInput(['name'=>'contrasena','type'=>'password','placeholder'=>'Contraseña','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Contraseña','required'=>true]);
		?>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/registrar.php'): ?>
		<b>Registrarse</b><hr>
		<?php
		echo pInput(['name'=>'nombre','placeholder'=>'Nombre','pattern'=>'[a-zA-Z ]+','minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>'Nombre','required'=>true]).
		pInput(['name'=>'usuario','placeholder'=>'Usuario','pattern'=>'[a-zA-Z0-9]+','minlength'=>4,'maxlength'=>20,'label'=>true,'texto'=>'Usuario','required'=>true]).
		pInput(['name'=>'email','placeholder'=>'Email','minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>'E-mail','required'=>true]).
		pInput(['name'=>'contrasena','type'=>'password','placeholder'=>'Contraseña','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Contraseña','required'=>true]).
		pInput(['name'=>'contrasena_confirmar','type'=>'password','placeholder'=>'Contraseña','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Repite la contraseña','required'=>true]).
		pInput(['name'=>'key_rol','placeholder'=>'Key','pattern'=>'^[a-zA-Z0-9-]{4,50}$','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Key (opcional)']);
		?>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/olvide-contrasena.php'): ?>
		<b>Recuperar cuenta</b><hr>
		<?php
		echo pInput(['name'=>'usuario','placeholder'=>'Usuario','pattern'=>'[a-zA-Z0-9]+','minlength'=>4,'maxlength'=>20,'label'=>true,'texto'=>'Usuario','required'=>true]).
		pInput(['name'=>'email','placeholder'=>'Email','minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>'E-mail','required'=>true]).
		pInput(['name'=>'contrasena','type'=>'password','placeholder'=>'Contraseña','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Contraseña (opcional)']);
		?>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/cambiar-contrasena.php'): ?>
		<b>Cambiar contraseña</b><hr>
		<?php if(!isset($_SESSION['cambiar_contrasena'])): ?>
		<?php
		echo pInput(['name'=>'contrasena','type'=>'password','placeholder'=>'Contraseña','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Contraseña antigua','required'=>true]).
		pInput(['name'=>'nueva_contrasena','type'=>'password','placeholder'=>'Contraseña','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Nueva contraseña','required'=>true]).
		pInput(['name'=>'nueva_contrasena_confirmar','type'=>'password','placeholder'=>'Contraseña','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Repite la contraseña','required'=>true]);
		?>
		<?php endif; ?>
		<?php if(isset($_SESSION['cambiar_contrasena'])):
		echo pInput(['name'=>'nueva_contrasena','type'=>'password','placeholder'=>'Contraseña','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Nueva contraseña']).
		pInput(['name'=>'nueva_contrasena_confirmar','type'=>'password','placeholder'=>'Contraseña','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Repite la contraseña']);
		endif; ?>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/configuracion.php'): ?>
		<?php if(!isset($_GET['up'])): ?>
			<b>Configuración</b><hr>
			<a class="boton" href="?up=actualizar_datos">Actualizar datos</a>
			<a class="boton" href="cambiar-contrasena<?php echo $Web['config']['php']; ?>">Cambiar contraseña</a>
			<a class="boton" href="?up=actualizar_datos_avatar">Cambiar avatar</a>
			<a class="boton" href="?up=actualizar_datos_rol">Actualizar Rol</a>
			<a class="boton" href="?up=eliminar_cuenta">Eliminar cuenta</a>
		<?php endif; ?>
		<?php if(isset($_GET['up'])): ?>
			<?php if($_GET['up'] == 'actualizar_datos'): ?>
			<b>Actualizar datos</b><hr>
			<?php
			echo pInput(['name'=>'nombre','placeholder'=>'Nombre','pattern'=>'[a-zA-Z ]+','minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>'Nombre','value'=>usu[$_SESSION['id']]['nombre'],'required'=>true]).
			pTextarea(['name'=>'descripcion','placeholder'=>'Descripción','minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>'Descripción','value'=>(isset(usu[$_SESSION['id']]['descripcion']) ? usu[$_SESSION['id']]['descripcion'] : 'Descripción default'),'required'=>true]).
			pInput(['name'=>'email','placeholder'=>'Email','minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>'E-mail','value'=>usu[$_SESSION['id']]['email'],'required'=>true]).
			pInput(['name'=>'red_social_nombre','placeholder'=>'Nombre de la red social','minlength'=>1,'maxlength'=>50,'label'=>true,'texto'=>'Nombre de la red social','value'=>(isset(usu[$_SESSION['id']]['red_social_nombre']) ? usu[$_SESSION['id']]['red_social_nombre'] : 'dbproject'),'required'=>true]).
			pInput(['type'=>'url','name'=>'red_social_enlace','placeholder'=>'Enlace de la red social','minlength'=>5,'maxlength'=>100,'label'=>true,'texto'=>'Enlace de la red social','value'=>(isset(usu[$_SESSION['id']]['red_social_enlace']) ? usu[$_SESSION['id']]['red_social_enlace'] : 'https://dbproject.rf.gd'),'required'=>true]).
			pInput(['name'=>'contrasena','type'=>'password','placeholder'=>'Contraseña','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Contraseña','required'=>true]).
			pInput(['name'=>'tipo','type'=>'hidden','value'=>'actualizar_datos_configuracion','des_session'=>true,'placeholder'=>'tipo','required'=>true]);
			?>
			<?php endif; ?>
			<?php if($_GET['up'] == 'actualizar_datos_avatar'): ?>
			<b>Subir avatar</b><hr>
			<p>Antes de subir una imagen usa: <a target="_blank" href="https://tinypng.com/" rel="nofollow">TinyPNG</a>, para optimizar la imagen.</p><hr>
			<?php
			echo pInput(['type'=>'file','accept'=>'.jpg,.jpeg,.png,.gif','name'=>'imagen','placeholder'=>'Avatar','label'=>true,'texto'=>'Sube un avatar','value'=>(isset(usu[$_SESSION['id']]['avatar']) ? usu[$_SESSION['id']]['avatar'] : 'default'),'required'=>true]).
			pInput(['name'=>'contrasena','type'=>'password','placeholder'=>'Contraseña','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Contraseña','required'=>true]).
			pInput(['name'=>'tipo','type'=>'hidden','value'=>'actualizar_datos_avatar','des_session'=>true,'placeholder'=>'tipo','required'=>true]);
			?>
			<hr><p>Recomiendo usar avatares con un tamaño de 250px o 500px.</p>
			<?php endif; ?>
			<?php if($_GET['up'] == 'actualizar_datos_rol'): ?>
			<b>Actualizar Rol</b><hr>
			<?php
			echo pInput(['name'=>'key_rol','placeholder'=>'Key','pattern'=>'^[a-zA-Z0-9-]{4,50}$','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Key']).
			pInput(['name'=>'tipo','type'=>'hidden','value'=>'actualizar_datos_rol','des_session'=>true,'placeholder'=>'tipo','required'=>true]);
			?>
			<hr><p>Optén un rol desde: <a target="_blank" href="https://dbproject.rf.gd/keys_rol">dbproject</a></p>
			<?php endif; ?>
			<?php if($_GET['up'] == 'eliminar_cuenta'): ?>
			<b>Eliminar cuenta</b><hr>
			<p><b>Atención:</b> se eliminaran todos los datos registrados, favoritos, comentarios y todo lo demas.</p><hr>
			<?php
			echo pSelect(['name'=>'motivos','option'=>['Tengo otra cuenta','Ya no usare esta plataforma','Otros motivos'],'label'=>true,'texto'=>'Motivos']).
			pSelect(['name'=>'confirmar','option'=>['No eliminar','Si eliminar'],'label'=>true,'texto'=>'Deseas eliminar la cuenta?']).
			pTextarea(['name'=>'motivos_texto','placeholder'=>'Motivos','minlength'=>4,'maxlength'=>150,'label'=>true,'texto'=>'Motivos','value'=>'','required'=>true]).
			pInput(['name'=>'contrasena','type'=>'password','placeholder'=>'Contraseña','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>'Contraseña','required'=>true]).
			pInput(['name'=>'tipo','type'=>'hidden','value'=>'eliminar_cuenta','des_session'=>true,'placeholder'=>'tipo','required'=>true]);
			?>
			<hr><p><b>Recuerda que ya no tendras acceso a esta cuenta.</b></p>
			<?php endif; ?>
		<?php endif; ?>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/configuracion.php' && isset($_GET['up']) or $Web['ruta_completa'] != '../auth/configuracion.php'): ?>
		<hr>
		<?php $a=rand(1,15); $b=rand(1,15); $c=$a+$b; ?>
		<label>Cuanto es <?php echo $a.' + '.$b; ?>: <input type="number" min="1" max="99" maxlength="1" name="resultado" pattern="[0-9]" required></label>
		<input type="hidden" name="resultado_verificar" value="<?php echo md5('R+_'.$c.'-W'); ?>"><hr>
		<?php endif; ?>

		<?php if($Web['ruta_completa'] == '../auth/iniciar.php'): ?>
		<input class="boton" type="submit" name="iniciar" value="Iniciar">
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/registrar.php'): ?>
		<input class="boton" type="submit" name="registrar" value="Registrarse">
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/olvide-contrasena.php'): ?>
		<input class="boton" type="submit" name="olvide_contrasena" value="Recuperar">
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/cambiar-contrasena.php'): ?>
		<div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
			<?php if(isset($_SESSION['cambiar_contrasena'])): ?>
			<input class="boton2" type="submit" name="no_cambiar_contrasena" value="No cambiar">
			<?php endif; ?>
			<?php if(!isset($_SESSION['cambiar_contrasena'])): ?>
			<a class="boton2" href="iniciar<?php echo $Web['config']['php']; ?>">No cambiar</a>
			<?php endif; ?>
			<input class="boton" type="submit" name="cambiar_contrasena" value="Cambiar contraseña">
		</div>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/configuracion.php'): ?>
			<?php if(isset($_GET['up'])):
				$list_datos_up_configuracion = ['actualizar_datos','actualizar_datos_avatar','actualizar_datos_configuracion','actualizar_datos_rol','eliminar_cuenta'];
				foreach ($list_datos_up_configuracion as $key => $value) {
					if($_GET['up'] == $value){
						echo '<input class="boton" type="submit" name="configuracion" value="Actualizar">';
					}
				}
				?>
				<hr><div><a class="boton2" href="configuracion<?php echo $Web['config']['php']; ?>"><i class="fas fa-arrow-left"></i> Volver</a></div>
			<?php endif; ?>
		<?php endif; ?>
		<?php if(!isset($_SESSION['id']) && !isset($_SESSION['rol'])): ?>
		<hr>
		<p class="t-14"><a href="<?php echo $Web['directorio'].'auth/iniciar'.$Web['config']['php']; ?>">Iniciar</a> ~ <a href="<?php echo $Web['directorio'].'auth/registrar'.$Web['config']['php']; ?>">Registrarse</a> ~ <a href="<?php echo $Web['directorio'].'auth/olvide-contrasena'.$Web['config']['php']; ?>">Olvide mi contraseña</a></p>
		<?php endif; ?>
	</form>
	</div>
<?php } ?> 