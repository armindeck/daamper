<?php #FORMULARIO DE INICIAR, REGISTRAR, OLVIDE CONTRASENA, CAMBIAR CONTRASEÑA, MODIFICAR DATOS
if($Web['ruta_completa'] == '../auth/login.php' || $Web['ruta_completa'] == '../auth/register.php' || $Web['ruta_completa'] == '../auth/forgot-password.php' || $Web['ruta_completa'] == '../auth/change-password.php' || $Web['ruta_completa'] == '../auth/config.php'){ ?>
	<div style="display: flex; flex-wrap: wrap; justify-content: center; margin: 20px 0px;">
	<style type="text/css">.auth label { display:flex; flex-wrap:wrap; flex-direction: column; justify-content:space-between; gap: 4px; }</style>
	<form class="formulario flex-column auth" style="gap: 4px; width: 100%; margin: 0px 4px; max-width: 640px;" method="post" action="<?php echo $Web['directorio']; ?>process/auth.php" <?php if($Web['ruta_completa']=='../auth/config.php' && isset($_GET['up']) && $_GET['up']=='change-avatar'){ echo 'enctype="multipart/form-data"'; } ?>>
		
		<?php /*------------------ LOGIN --------------------*/ ?>
		<?php if($Web['ruta_completa'] == '../auth/login.php'): ?>
		<b><?= Language('login') ?></b><hr>
		<?=
		pInput(['name'=>'usuario','placeholder'=> Language('user'),'pattern'=>'[a-zA-Z0-9]+','minlength'=>4,'maxlength'=>20,'label'=>true,'texto'=> Language('user'),'required'=>true]).
		pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=> Language('password'),'required'=>true]);
		?>
		<?php endif; ?>

		<?php /*------------------ REGISTER --------------------*/ ?>
		<?php if($Web['ruta_completa'] == '../auth/register.php'): ?>
		<b><?= Language('register') ?></b><hr>
		<?=
		pInput(['name'=>'nombre','placeholder'=>Language('name'),'pattern'=>'[a-zA-Z ]+','minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>Language('name'),'required'=>true]).
		pInput(['name'=>'usuario','placeholder'=> Language('user'),'pattern'=>'[a-zA-Z0-9]+','minlength'=>4,'maxlength'=>20,'label'=>true,'texto'=> Language('user'),'required'=>true]).
		pInput(['name'=>'email','placeholder'=>Language('email'),'minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>Language('email'),'required'=>true]).
		pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=> Language('password'),'required'=>true]).
		pInput(['name'=>'contrasena_confirmar','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('repeat-password'),'required'=>true])
		?>
		<?php endif; ?>

		<?php /*------------------ FORGOT PASSWORD --------------------*/ ?>
		<?php if($Web['ruta_completa'] == '../auth/forgot-password.php'): ?>
		<b><?= Language('recover-account') ?></b><hr>
		<?=
		pInput(['name'=>'user-or-email','placeholder'=>Language('username-or-email'),'minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>Language('username-or-email'),'required'=>true]).
		pInput(['name'=>'pin','placeholder'=> Language('pin'),'minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=> Language('pin'),'required'=>true])
		?>
		<?php endif; ?>
		
		<?php /*------------------ CHANGE PASSWORD --------------------*/ ?>
		<?php if($Web['ruta_completa'] == '../auth/change-password.php'): ?>
		<b><?= Language('change-password') ?></b><hr>
		<?php if(!isset($_SESSION['cambiar_contrasena'])): ?>
		<?=
		pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('old-password'),'required'=>true]).
		pInput(['name'=>'nueva_contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('new-password'),'required'=>true]).
		pInput(['name'=>'nueva_contrasena_confirmar','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('repeat-password'),'required'=>true]);
		?>
		<?php endif; ?>
		<?= isset($_SESSION['cambiar_contrasena']) ?
		pInput(['name'=>'nueva_contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('new-password')]).
		pInput(['name'=>'nueva_contrasena_confirmar','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=>Language('repeat-password')])
		: "" ?>
		<?php endif; ?>
		
		<?php /*------------------ SETTINGS --------------------*/ ?>
		<?php if($Web['ruta_completa'] == '../auth/config.php'): ?>
		<?php if(!isset($_GET['up'])): ?>
			<b><?= Language('settings') ?></b><hr>
			<a class="boton" href="?up=update-data"><?= Language('update-data') ?></a>
			<a class="boton" href="?up=pin"><?= Language('show-pin') ?></a>
			<a class="boton" href="change-password<?php echo $Web['config']['php']; ?>"><?= Language('change-password') ?></a>
			<a class="boton" href="?up=change-avatar"><?= Language('change-avatar') ?></a>
			<a class="boton" href="?up=delete-account"><?= Language('delete-account') ?></a>
		<?php endif; ?>
		<?php if(isset($_GET['up']) && in_array($_GET["up"], ["update-data", "change-avatar", "change-password", "delete-account", "pin"])){ ?>
			
			<?php /*------------------ UPDATE DATA --------------------*/ ?>
			<?php if($_GET['up'] == 'update-data'): ?>
			<b><?= Language('update-data') ?></b><hr>
			<?php $default = Daamper::$data->Config("default")["auth"]["update-data"];
			echo pInput(['name'=>'nombre','placeholder'=>Language('name'),'pattern'=>'[a-zA-Z ]+','minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>Language('name'),'value'=>Daamper::$data->UserByID($_SESSION['id'])['nombre'],'required'=>true]).
			pTextarea(['name'=>'descripcion','placeholder'=>Language('description'),'minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>Language('description'),'value'=>(isset(Daamper::$data->UserByID($_SESSION['id'])['descripcion']) ? Daamper::$data->UserByID($_SESSION['id'])['descripcion'] : $default["description"]),'required'=>true]).
			pInput(['name'=>'email','placeholder'=>Language('email'),'minlength'=>4,'maxlength'=>50,'label'=>true,'texto'=>Language('email'),'value'=>Daamper::$data->UserByID($_SESSION['id'])['email'],'required'=>true]).
			pInput(['name'=>'red_social_nombre','placeholder'=>Language('social-name'),'minlength'=>1,'maxlength'=>50,'label'=>true,'texto'=>Language('social-name'),'value'=>(isset(Daamper::$data->UserByID($_SESSION['id'])['red_social_nombre']) ? Daamper::$data->UserByID($_SESSION['id'])['red_social_nombre'] : $default["social-network-name"]),'required'=>true]).
			pInput(['type'=>'url','name'=>'red_social_enlace','placeholder'=>Language('social-link'),'minlength'=>5,'maxlength'=>100,'label'=>true,'texto'=>Language('social-link'),'value'=>(isset(Daamper::$data->UserByID($_SESSION['id'])['red_social_enlace']) ? Daamper::$data->UserByID($_SESSION['id'])['red_social_enlace'] : $default["social-network-link"]),'required'=>true]).
			pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=> Language('password'),'required'=>true]).
			pInput(['name'=>'tipo','type'=>'hidden','value'=>'actualizar_datos_configuracion','des_session'=>true,'placeholder'=>'tipo','required'=>true]);
			?>
			<?php endif; ?>
			
			<?php /*------------------ CHANGE AVATAR --------------------*/ ?>
			<?php if($_GET['up'] == 'change-avatar'): ?>
			<b><?= Language('upload-avatar') ?></b><hr>
			<p><?= Language(['upload-image', 'recommended'], 'dashboard', ['value' => '<a target="_blank" rel="nofollow" href="https://tinypng.com/">TinyPNG</a>']) ?></p><hr>
			<?=
			pInput(['type'=>'file','accept'=>'.jpg,.jpeg,.png,.gif','name'=>'imagen','placeholder'=>'Avatar','label'=>true,'texto'=>Language('upload-avatar'),'value'=>(isset(Daamper::$data->UserByID($_SESSION['id'])['avatar']) ? Daamper::$data->UserByID($_SESSION['id'])['avatar'] : 'default'),'required'=>true]).
			pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=> Language('password'),'required'=>true]).
			pInput(['name'=>'tipo','type'=>'hidden','value'=>'actualizar_datos_avatar','des_session'=>true,'placeholder'=>'tipo','required'=>true]);
			?>
			<hr><p><?= Language('avatar-size-recommendation') ?></p>
			<?php endif; ?>
			
			<?php /*------------------ DELETE ACCOUNT --------------------*/ ?>
			<?php if($_GET['up'] == 'delete-account'): ?>
			<b><?= Language('delete-account') ?></b><hr>
			<p><?= Language('delete-warning') ?></p><hr>
			<?=
			pSelect(['name'=>'motivos','option'=>[Language('have-other-account'), Language('no-longer-use'), Language('other-reasons')],'label'=>true,'texto'=>Language('reasons')]).
			pSelect(['name'=>'confirmar','option'=>['No eliminar' => Language('no-delete'),'Si eliminar' => Language('yes-delete')],'label'=>true,'texto'=>Language('confirm-delete')]).
			pTextarea(['name'=>'motivos_texto','placeholder'=>Language('reasons'),'minlength'=>4,'maxlength'=>150,'label'=>true,'texto'=>Language('reasons'),'value'=>'','required'=>true]).
			pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=> Language('password'),'required'=>true]).
			pInput(['name'=>'tipo','type'=>'hidden','value'=>'eliminar_cuenta','des_session'=>true,'placeholder'=>'tipo','required'=>true]);
			?>
			<hr><p><b><?= Language('delete-reminder') ?></b></p>
			<?php endif; ?>

			<?php /*------------------ PIN --------------------*/ ?>
			<?php if($_GET['up'] == 'pin'): ?>
			<b><?= Language('recovery-pin') ?></b><hr>
			<?= (Daamper::$data->UserAll()[$_SESSION["id"]]["pin"] ?? "") == "55LE-99Q9R-TFU5V39" ? "<p>" . Language("please-change-recovery-pin-default") . "</p>" : "" ?>
			<div class="flex-evenly items-center">
				<input type="checkbox" class="show-key" id="show-pin" hidden>
				<label for="show-pin"><a class="boton-2"><i class="fas fa-eye"></i></a></label>
				<section class="campo flex-1 key-show t-center">
					<p class="key-show__key" hidden><?= Daamper::$data->UserAll()[$_SESSION["id"]]["pin"] ?? Language("undefined"); ?></p>
					<p class="key-show__hidden">*********</p>
				</section>
			</div><br>
			<?=
			pInput(['name'=>'contrasena','type'=>'password','placeholder'=> Language('password'),'minlength'=>8,'maxlength'=>50,'label'=>true,'texto'=> Language('password'),'required'=>true]).
			pInput(['name'=>'tipo','type'=>'hidden','value'=>'actualizar_datos_configuracion_pin','des_session'=>true,'placeholder'=>'tipo','required'=>true]);
			?>
			<?php endif; ?>
		
		<?php } elseif(isset($_GET["up"])) {
			echo Language("undefined");
		} ?>
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/config.php' && isset($_GET['up']) && in_array($_GET["up"], ["update-data", "change-avatar", "change-password", "delete-account", "pin"]) or $Web['ruta_completa'] != '../auth/config.php'): ?>
		<hr>
		<?php $suma = Daamper::$scripts->SimpleSuma(); ?>
		<label><?= Language('math-question', 'global', ['value' => $suma["a"], 'value2' => $suma["b"]]) ?>: <input type="number" min="<?= $suma["min-input"] ?>" max="<?= $suma["max-input"] ?>" maxlength="1" name="resultado" pattern="[0-9]" required></label>
		<input type="hidden" name="resultado_verificar" value="<?= Daamper::$scripts->SimpleToken($suma["c"]); ?>" required><hr>
		<?php endif; ?>

		<?php if($Web['ruta_completa'] == '../auth/login.php'): ?>
		<input class="boton" type="submit" name="iniciar" value="<?= Language('login') ?>">
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/register.php'): ?>
		<input class="boton" type="submit" name="registrar" value="<?= Language('register') ?>">
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/forgot-password.php'): ?>
		<input class="boton" type="submit" name="olvide_contrasena" value="<?= Language('recover') ?>">
		<?php endif; ?>
		<?php if($Web['ruta_completa'] == '../auth/change-password.php'): ?>
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
		<?php if($Web['ruta_completa'] == '../auth/config.php'): ?>
			<?php if(isset($_GET['up'])):
				$list_datos_up_configuracion = ['actualizar_datos' => "update-data",'actualizar_datos_avatar' => "change-avatar",'actualizar_datos_configuracion','actualizar_datos_configuracion_pin' => 'pin','eliminar_cuenta' => "delete-account"];
				foreach ($list_datos_up_configuracion as $key => $value) {
					if($_GET['up'] == $value){
						echo '<input class="boton" type="submit" name="configuracion" value="'.
						(
							Language(
								$key == 'eliminar_cuenta' ? 'delete-account' :
								($key == 'actualizar_datos_configuracion_pin' ? 'new-pin' : 'update')
							) ?? Language('undefined')
						).'">';
					}
				}
				?>
				<hr><div><a class="boton2" href="config<?php echo $Web['config']['php']; ?>"><i class="fas fa-arrow-left"></i> <?= Language('go-back') ?></a></div>
			<?php endif; ?>
		<?php endif; ?>
		<?php if(!isset($_SESSION['id']) && !isset($_SESSION['rol'])): ?>
		<hr>
		<p class="t-14"><a href="<?php echo $Web['directorio'].'auth/login'.$Web['config']['php']; ?>"><?= Language('login') ?></a> ~ <a href="<?php echo $Web['directorio'].'auth/register'.$Web['config']['php']; ?>"><?= Language('register') ?></a> ~ <a href="<?php echo $Web['directorio'].'auth/forgot-password'.$Web['config']['php']; ?>"><?= Language('forgot-password') ?></a></p>
		<?php endif; ?>
	</form>
	</div>
<?php } ?> 