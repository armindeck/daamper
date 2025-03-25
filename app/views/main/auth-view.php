<?php #FORMULARIO DE INICIAR, REGISTRAR, OLVIDE CONTRASENA, CAMBIAR CONTRASEÑA, MODIFICAR DATOS
if($Web['ruta_completa'] == '../auth/iniciar.php' || $Web['ruta_completa'] == '../auth/registrar.php' || $Web['ruta_completa'] == '../auth/olvide-contrasena.php' || $Web['ruta_completa'] == '../auth/cambiar-contrasena.php' || $Web['ruta_completa'] == '../auth/configuracion.php'){ ?>
	<div style="display: flex; flex-wrap: wrap; justify-content: center; margin: 20px 0px;">
	<style type="text/css">.auth label { display:flex; flex-wrap:wrap; flex-direction: column; justify-content:space-between; gap: 4px; }</style>
	<form class="formulario flex-column auth" style="gap: 4px; width: 100%; margin: 0px 4px; max-width: 640px;" method="post" action="<?php echo $Web['directorio']; ?>procesa/procesa.auth.php" <?php if($Web['ruta_completa']=='../auth/configuracion.php' && isset($_GET['up']) && $_GET['up']=='actualizar_datos_avatar'){ echo 'enctype="multipart/form-data"'; } ?>>
		<?php if($Web['ruta_completa'] == '../auth/iniciar.php'): ?>
		<b><?= Language('login') ?></b><hr>
		<?php
		echo pInput(['name'=>'usuario','placeholder'=> Language('user'),'pattern'=>'[a-zA-Z0-9]+','minlength'=>4,'maxlength'=>20,'label'=>true,'texto'=> Language('user'),'required'=>true]).
		pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=> Language('password'),'required'=>true]);
		?>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/registrar.php'): ?>
		<b><?= Language('register') ?></b><hr>
		<?php
		echo pInput(['name'=>'nombre','placeholder'=>Language('name'),'pattern'=>'[a-zA-Z ]+','minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>Language('name'),'required'=>true]).
		pInput(['name'=>'usuario','placeholder'=> Language('user'),'pattern'=>'[a-zA-Z0-9]+','minlength'=>4,'maxlength'=>20,'label'=>true,'texto'=> Language('user'),'required'=>true]).
		pInput(['name'=>'email','placeholder'=>Language('email'),'minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>Language('email'),'required'=>true]).
		pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=> Language('password'),'required'=>true]).
		pInput(['name'=>'contrasena_confirmar','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('repeat-password'),'required'=>true]).
		pInput(['name'=>'key_rol','placeholder'=> Language('key'),'pattern'=>'^[a-zA-Z0-9-]{4,50}$','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('key').' ('.Language('optional').')']);
		?>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/olvide-contrasena.php'): ?>
		<b><?= Language('recover-account') ?></b><hr>
		<?php
		echo pInput(['name'=>'usuario','placeholder'=> Language('user'),'pattern'=>'[a-zA-Z0-9]+','minlength'=>4,'maxlength'=>20,'label'=>true,'texto'=> Language('user'),'required'=>true]).
		pInput(['name'=>'email','placeholder'=>Language('email'),'minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>Language('email'),'required'=>true]).
		pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('password').' ('.Language('optional').')']);
		?>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/cambiar-contrasena.php'): ?>
		<b><?= Language('change-password') ?></b><hr>
		<?php if(!isset($_SESSION['cambiar_contrasena'])): ?>
		<?php
		echo pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('old-password'),'required'=>true]).
		pInput(['name'=>'nueva_contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('new-password'),'required'=>true]).
		pInput(['name'=>'nueva_contrasena_confirmar','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('repeat-password'),'required'=>true]);
		?>
		<?php endif; ?>
		<?php if(isset($_SESSION['cambiar_contrasena'])):
		echo pInput(['name'=>'nueva_contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('new-password')]).
		pInput(['name'=>'nueva_contrasena_confirmar','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('repeat-password')]);
		endif; ?>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/configuracion.php'): ?>
		<?php if(!isset($_GET['up'])): ?>
			<b><?= Language('settings') ?></b><hr>
			<a class="boton" href="?up=actualizar_datos"><?= Language('update-data') ?></a>
			<a class="boton" href="cambiar-contrasena<?php echo $Web['config']['php']; ?>"><?= Language('change-password') ?></a>
			<a class="boton" href="?up=actualizar_datos_avatar"><?= Language('change-avatar') ?></a>
			<a class="boton" href="?up=actualizar_datos_rol"><?= Language('update-role') ?></a>
			<a class="boton" href="?up=eliminar_cuenta"><?= Language('delete-account') ?></a>
		<?php endif; ?>
		<?php if(isset($_GET['up'])): ?>
			<?php if($_GET['up'] == 'actualizar_datos'): ?>
			<b><?= Language('update-data') ?></b><hr>
			<?php
			echo pInput(['name'=>'nombre','placeholder'=>Language('name'),'pattern'=>'[a-zA-Z ]+','minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>Language('name'),'value'=>usu[$_SESSION['id']]['nombre'],'required'=>true]).
			pTextarea(['name'=>'descripcion','placeholder'=>Language('description'),'minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>Language('description'),'value'=>(isset(usu[$_SESSION['id']]['descripcion']) ? usu[$_SESSION['id']]['descripcion'] : Language('description')),'required'=>true]).
			pInput(['name'=>'email','placeholder'=>Language('email'),'minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>Language('email'),'value'=>usu[$_SESSION['id']]['email'],'required'=>true]).
			pInput(['name'=>'red_social_nombre','placeholder'=>Language('social-name'),'minlength'=>1,'maxlength'=>50,'label'=>true,'texto'=>Language('social-name'),'value'=>(isset(usu[$_SESSION['id']]['red_social_nombre']) ? usu[$_SESSION['id']]['red_social_nombre'] : 'dbproject'),'required'=>true]).
			pInput(['type'=>'url','name'=>'red_social_enlace','placeholder'=>Language('social-link'),'minlength'=>5,'maxlength'=>100,'label'=>true,'texto'=>Language('social-link'),'value'=>(isset(usu[$_SESSION['id']]['red_social_enlace']) ? usu[$_SESSION['id']]['red_social_enlace'] : 'https://dbproject.rf.gd'),'required'=>true]).
			pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=> Language('password'),'required'=>true]).
			pInput(['name'=>'tipo','type'=>'hidden','value'=>'actualizar_datos_configuracion','des_session'=>true,'placeholder'=>'tipo','required'=>true]);
			?>
			<?php endif; ?>
			<?php if($_GET['up'] == 'actualizar_datos_avatar'): ?>
			<b><?= Language('upload-avatar') ?></b><hr>
			<p><?= Language(['subir-imagen', 'recommended'], 'dashboard', ['value' => '<a target="_blank" rel="nofollow" href="https://tinypng.com/">TinyPNG</a>']) ?></p><hr>
			<?php
			echo pInput(['type'=>'file','accept'=>'.jpg,.jpeg,.png,.gif','name'=>'imagen','placeholder'=>'Avatar','label'=>true,'texto'=>Language('upload-avatar'),'value'=>(isset(usu[$_SESSION['id']]['avatar']) ? usu[$_SESSION['id']]['avatar'] : 'default'),'required'=>true]).
			pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=> Language('password'),'required'=>true]).
			pInput(['name'=>'tipo','type'=>'hidden','value'=>'actualizar_datos_avatar','des_session'=>true,'placeholder'=>'tipo','required'=>true]);
			?>
			<hr><p><?= Language('avatar-size-recommendation') ?></p>
			<?php endif; ?>
			<?php if($_GET['up'] == 'actualizar_datos_rol'): ?>
			<b><?= Language('update-role') ?></b><hr>
			<?php
			echo pInput(['name'=>'key_rol','placeholder'=> Language('key'),'pattern'=>'^[a-zA-Z0-9-]{4,50}$','minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=> Language('key')]).
			pInput(['name'=>'tipo','type'=>'hidden','value'=>'actualizar_datos_rol','des_session'=>true,'placeholder'=>'tipo','required'=>true]);
			?>
			<hr><p><?= Language('get-role', 'global', ['value' => CONFIG['nombre_web']]) ?></p>
			<?php endif; ?>
			<?php if($_GET['up'] == 'eliminar_cuenta'): ?>
			<b><?= Language('delete-account') ?></b><hr>
			<p><?= Language('delete-warning') ?></p><hr>
			<?php
			echo pSelect(['name'=>'motivos','option'=>[Language('have-other-account'), Language('no-longer-use'), Language('other-reasons')],'label'=>true,'texto'=>Language('reasons')]).
			pSelect(['name'=>'confirmar','option'=>['No eliminar' => Language('no-delete'),'Si eliminar' => Language('yes-delete')],'label'=>true,'texto'=>Language('confirm-delete')]).
			pTextarea(['name'=>'motivos_texto','placeholder'=>Language('reasons'),'minlength'=>4,'maxlength'=>150,'label'=>true,'texto'=>Language('reasons'),'value'=>'','required'=>true]).
			pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=> Language('password'),'required'=>true]).
			pInput(['name'=>'tipo','type'=>'hidden','value'=>'eliminar_cuenta','des_session'=>true,'placeholder'=>'tipo','required'=>true]);
			?>
			<hr><p><b><?= Language('delete-reminder') ?></b></p>
			<?php endif; ?>
		<?php endif; ?>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/configuracion.php' && isset($_GET['up']) or $Web['ruta_completa'] != '../auth/configuracion.php'): ?>
		<hr>
		<?php $a=rand(1,15); $b=rand(1,15); $c=$a+$b; ?>
		<label><?= Language('math-question', 'global', ['value' => $a, 'value2' => $b]) ?>: <input type="number" min="1" max="99" maxlength="1" name="resultado" pattern="[0-9]" required></label>
		<input type="hidden" name="resultado_verificar" value="<?php echo md5('R+_'.$c.'-W'); ?>"><hr>
		<?php endif; ?>

		<?php if($Web['ruta_completa'] == '../auth/iniciar.php'): ?>
		<input class="boton" type="submit" name="iniciar" value="<?= Language('login') ?>">
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/registrar.php'): ?>
		<input class="boton" type="submit" name="registrar" value="<?= Language('register') ?>">
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/olvide-contrasena.php'): ?>
		<input class="boton" type="submit" name="olvide_contrasena" value="<?= Language('recover') ?>">
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/cambiar-contrasena.php'): ?>
		<div style="display: flex; flex-wrap: wrap; justify-content: space-between;">
			<?php if(isset($_SESSION['cambiar_contrasena'])): ?>
			<input class="boton2" type="submit" name="no_cambiar_contrasena" value="<?= Language('no-change') ?>">
			<?php endif; ?>
			<?php if(!isset($_SESSION['cambiar_contrasena'])): ?>
			<a class="boton2" href="iniciar<?php echo $Web['config']['php']; ?>"><?= Language('no-change') ?></a>
			<?php endif; ?>
			<input class="boton" type="submit" name="cambiar_contrasena" value="<?= Language('change-password') ?>">
		</div>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/configuracion.php'): ?>
			<?php if(isset($_GET['up'])):
				$list_datos_up_configuracion = ['actualizar_datos','actualizar_datos_avatar','actualizar_datos_configuracion','actualizar_datos_rol','eliminar_cuenta'];
				foreach ($list_datos_up_configuracion as $key => $value) {
					if($_GET['up'] == $value){
						echo '<input class="boton" type="submit" name="configuracion" value="'.Language($value == 'eliminar_cuenta' ? 'delete-account' : 'update').'">';
					}
				}
				?>
				<hr><div><a class="boton2" href="configuracion<?php echo $Web['config']['php']; ?>"><i class="fas fa-arrow-left"></i> <?= Language('go-back') ?></a></div>
			<?php endif; ?>
		<?php endif; ?>
		<?php if(!isset($_SESSION['id']) && !isset($_SESSION['rol'])): ?>
		<hr>
		<p class="t-14"><a href="<?php echo $Web['directorio'].'auth/iniciar'.$Web['config']['php']; ?>"><?= Language('login') ?></a> ~ <a href="<?php echo $Web['directorio'].'auth/registrar'.$Web['config']['php']; ?>"><?= Language('register') ?></a> ~ <a href="<?php echo $Web['directorio'].'auth/olvide-contrasena'.$Web['config']['php']; ?>"><?= Language('forgot-password') ?></a></p>
		<?php endif; ?>
	</form>
	</div>
<?php } ?> 