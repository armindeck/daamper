<?php # MOD: 24/12/2024 | 24/03/2025
$Web['directorio'] = '../'; $Web['ruta'] = 'procesa/procesa.auth.php';
if(isset($_SESSION['tmpForm'])){ unset($_SESSION['tmpForm']); }
$list['procesa']=['iniciar','registrar','olvide_contrasena','cambiar_contrasena','no_cambiar_contrasena','configuracion'];
foreach ($list['procesa'] as $key => $value) {
	if(isset($_POST[$value]) && !empty($_POST[$value])){
		$TIPO = $value; break;
	}
}
require_once $Web['directorio'].'app/control/control_procesa.php';

if(!isset($TIPO)){
	mensajeSpan(['bg'=>'yellow', 'co'=>'#000','text'=> Language('no-access-file', 'auth'),'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"]);
}

$DIRECCION = $TIPO.$Web['config']['php'];
if (in_array($DIRECCION, ['olvide_contrasena', 'cambiar_contrasena'])) {
	$DIRECCION = str_replace('_', '-', $DIRECCION);
}

if(!isset($_POST['resultado']) || !isset($_POST['resultado_verificar'])){
	mensajeSpan(['bg'=>'red','text'=> Language('do-not-modify-hidden-fields', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}"]);
}

if($TIPO=='iniciar'){
	$list['datos_procesa'] = ['usuario','contrasena'];
}

if($TIPO=='registrar'){
	$list['datos_procesa'] = ['nombre','usuario','email','contrasena','contrasena_confirmar'];
}

if($TIPO=='olvide_contrasena'){
	$list['datos_procesa'] = ['usuario','email'];
}

if($TIPO=='cambiar_contrasena'){
	if(!isset($_SESSION['cambiar_contrasena'])){
		$list['datos_procesa'] = ['contrasena','nueva_contrasena','nueva_contrasena_confirmar'];
	} else {
		$list['datos_procesa'] = ['nueva_contrasena','nueva_contrasena_confirmar'];
	}
}

if($TIPO=='no_cambiar_contrasena'){
	$list['datos_procesa'] = ['no_cambiar_contrasena'];
}


if($TIPO=='configuracion'){
	if(isset($_POST['tipo'])){
		switch ($_POST['tipo']) {
			case 'actualizar_datos_configuracion':
					$list['datos_procesa'] = ['nombre','descripcion','email','red_social_nombre','red_social_enlace','contrasena'];
					$DIRECCION = 'configuracion'.$Web['config']['php'].'?up=actualizar_datos';
				break;
			case 'actualizar_datos_avatar':
				$list['datos_procesa'] = ['contrasena'];
				$DIRECCION = 'configuracion'.$Web['config']['php'].'?up=actualizar_datos_avatar';
				break;
			case 'actualizar_datos_rol':
				$list['datos_procesa'] = ['key_rol','contrasena'];
				$DIRECCION = 'configuracion'.$Web['config']['php'].'?up=actualizar_datos_rol';
				break;
			case 'eliminar_cuenta':
				$list['datos_procesa'] = ['motivos','confirmar','motivos_texto','contrasena'];
				$DIRECCION = 'configuracion'.$Web['config']['php'].'?up=eliminar_cuenta';
				break;
				
			default:
				mensajeSpan(['bg'=>'red','text'=> Language('do-not-modify-hidden-fields', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}"]);
				break;
		}
	} else {
		mensajeSpan(['bg'=>'red','text'=> Language('something-went-wrong', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}"]);
	}
}


foreach ($list['datos_procesa'] as $key => $value) {
	if($value=='usuario') {
		$pos[$value] = isset($_POST[$value]) ? SCRIPTS->sinEnes(SCRIPTS->sinAcentos(SCRIPTS->sinEspacios(SCRIPTS->darFormatoNoSimbolos(SCRIPTS->normalizar2($_POST[$value]))))) : '';
	} else {
		$pos[$value] = isset($_POST[$value]) ? SCRIPTS->normalizar2($_POST[$value]) : '';
	}
}

$list['datos_procesa_verificar'] = ['resultado','resultado_verificar'];

if(md5('R+_'. SCRIPTS->normalizar2($_POST['resultado']) .'-W') != SCRIPTS->normalizar2($_POST['resultado_verificar'])){
	if($TIPO=='no_cambiar_contrasena'){ $TIPO='cambiar_contrasena'; }
	mensajeSpan(['bg'=>'red','text'=> Language('incorrect-sum', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]);
}

if($TIPO=='no_cambiar_contrasena'){
	if(isset($_SESSION['id'])){
		unset($_SESSION['cambiar_contrasena']);
		mensajeSpan(['bg'=>'red','text'=> Language('recommend-password-change', 'auth'),'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"]);
	}
}

foreach ($list['datos_procesa'] as $key => $value) {
	if(!isset($_POST[$value])){
		mensajeSpan(['bg'=>'red','text'=> Language('fill-required-fields', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]); break;
	}
}

if($TIPO=='iniciar'){
	$verificar = strlen($pos['usuario']) > 3 && strlen($pos['usuario']) < 21 &&
		strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51;
}

if($TIPO=='registrar'){
	$verificar = strlen($pos['usuario']) > 3 && strlen($pos['usuario']) < 21 &&
		strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51 &&
		strlen($pos['contrasena_confirmar']) > 7 && strlen($pos['contrasena_confirmar']) < 51 &&
		strlen($pos['nombre']) > 3 && strlen($pos['nombre']) < 51 &&
		strlen($pos['email']) > 3 && strlen($pos['email']) < 51 &&
		filter_var($pos['email'], FILTER_VALIDATE_EMAIL);
}

if($TIPO=='configuracion'){

	if($_POST['tipo']=='actualizar_datos_configuracion'){
	$verificar = strlen($pos['descripcion']) > 3 && strlen($pos['descripcion']) < 51 &&
		strlen($pos['red_social_nombre']) > 0 && strlen($pos['red_social_nombre']) < 51 &&
		strlen($pos['red_social_enlace']) > 4 && strlen($pos['red_social_enlace']) < 101 &&
		filter_var($pos['red_social_enlace'], FILTER_VALIDATE_URL) &&
		strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51 &&
		strlen($pos['nombre']) > 3 && strlen($pos['nombre']) < 51 &&
		strlen($pos['email']) > 3 && strlen($pos['email']) < 51 &&
		filter_var($pos['email'], FILTER_VALIDATE_EMAIL);
	}

	if($_POST['tipo']=='actualizar_datos_avatar'){
		$verificar =
		strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51;
	}

	if($_POST['tipo']=='actualizar_datos_rol'){
		$verificar = strlen($pos['key_rol']) > 7 && strlen($pos['key_rol']) < 51 &&
		strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51;
	}

	if($_POST['tipo']=='eliminar_cuenta'){
		$verificar = strlen($pos['motivos']) > 3 && strlen($pos['motivos']) < 51 &&
		strlen($pos['confirmar']) > 3 && strlen($pos['confirmar']) < 51 &&
		strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51;
	}
}

if($TIPO=='olvide_contrasena'){
	$verificar = strlen($pos['usuario']) > 3 && strlen($pos['usuario']) < 21 &&
		strlen($pos['email']) > 3 && strlen($pos['email']) < 51 &&
		filter_var($pos['email'], FILTER_VALIDATE_EMAIL);
	if(!$verificar){
		if(isset($_POST['contrasena'])){
			$verificar = strlen($_POST['contrasena']) > 7 && strlen($_POST['contrasena']) < 51;
			$pos['contrasena'] = SCRIPTS->normalizar2($_POST['contrasena']);
		}
	}
}

if($TIPO=='cambiar_contrasena'){
	$verificar=true;
	if(!isset($_SESSION['cambiar_contrasena'])){
		$verificar = strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51;
	}
	if($verificar){
		$verificar = strlen($pos['nueva_contrasena']) > 7 && strlen($pos['nueva_contrasena']) < 51 &&
			strlen($pos['nueva_contrasena_confirmar']) > 7 && strlen($pos['nueva_contrasena_confirmar']) < 51;
	}
}


if(!$verificar) {
	mensajeSpan(['bg'=>'red','text'=> Language('fill-fields-with-data', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]);
}

if($TIPO=='registrar'){
	if($pos['contrasena'] != $pos['contrasena_confirmar']){
		mensajeSpan(['bg'=>'red','text'=> Language('password-mismatch', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]);
	}
}

if($TIPO=='cambiar_contrasena'){
	if($pos['nueva_contrasena'] != $pos['nueva_contrasena_confirmar']){
		mensajeSpan(['bg'=>'red','text'=> Language('password-mismatch', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}"]);
	}
}

if(mkdir($Web['directorio'].'app/database/usuarios/', 0777, true));
if(mkdir($Web['directorio'].'p/', 0777, true));
if(file_exists($Web['directorio'].AppDatabase('usuarios/usuarios'))){
	require_once $Web['directorio'].AppDatabase('usuarios/usuarios');
}
if(file_exists($Web['directorio'].AppDatabase('usuarios/usuarios_extras'))){
	require_once $Web['directorio'].AppDatabase('usuarios/usuarios_extras');
}

if($TIPO!='registrar'){
	if(!isset($usu)) {
		mensajeSpan(['bg'=>'red','text'=> Language('no-users-or-database', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]);
	}
}

if($TIPO=='iniciar'){
	foreach ($usu as $key => $value) {
		if(strtolower($pos['usuario']) == strtolower($value['usuario']) && md5($pos['contrasena']) == $value['contrasena']){
			if($value['estado']!='publico'){
				mensajeSpan(['bg'=>'red','text'=> Language('profile-suspended-or-deleted', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]);
			}
			$id_usuario = $value['id'];
			break;
		}
	}
}

if($TIPO=='configuracion'){
	if($_POST['tipo']=='actualizar_datos_configuracion'){
		foreach ($usu as $key => $value) {
			if($pos['email'] == $value['email']){
				if($_SESSION['id'] != $value['id']){
					mensajeSpan(['bg'=>'red','text'=> Language('email-already-used', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]);
				}
			}
		}
	}
	if($_POST['tipo']=='actualizar_datos_avatar'){
		require 'procs_img.php';
	}
}

if($TIPO=='olvide_contrasena'){
	foreach ($usu as $key => $value) {
		if(strtolower($pos['usuario']) == strtolower($value['usuario']) && $pos['email'] == $value['email']){
			if($value['estado']=='publico'){
				$id_usuario = $value['id'];
			}
			break;
		}
	}
	if(!isset($id_usuario) && isset($pos['contrasena'])) {
		foreach ($usu as $key => $value) {
			if(strtolower($pos['usuario']) == strtolower($value['usuario']) && md5($pos['contrasena']) == $value['contrasena']){
				if($value['estado']=='publico'){
					$id_usuario = $value['id'];
				}
				break;
			}
		}
	}
}


if($TIPO=='cambiar_contrasena'){
	if(!isset($_SESSION['cambiar_contrasena'])){
		if(md5($pos['contrasena']) != $usu[$_SESSION['id']]['contrasena']){
			mensajeSpan(['bg'=>'red','text'=> Language('incorrect-password', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}"]);
		}
	}
	if(md5($pos['nueva_contrasena']) == $usu[$_SESSION['id']]['contrasena']){
		mensajeSpan(['bg'=>'red','text'=> Language('use-another-password', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}"]);
	}
	$pos['nueva_contrasena'] = md5($pos['nueva_contrasena']);
}


if($TIPO == 'configuracion'){
	if(md5($pos['contrasena']) != $usu[$_SESSION['id']]['contrasena']){
		mensajeSpan(['bg'=>'red','text'=> Language('incorrect-password', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]);
	} else {
		unset($pos['contrasena']);
	}

	if($_POST['tipo']=='eliminar_cuenta'){
		if($pos['confirmar']!='Si eliminar'){
			mensajeSpan(['bg'=>'red','text'=> Language('confirm-deletion', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]);
		}

		unset($pos['confirmar']);
		$pos['fecha_eliminado'] = SCRIPTS->fecha_hora();
	} else {
		$pos['fecha_modificado'] = SCRIPTS->fecha_hora();
	}
}


if($TIPO=='iniciar'){
	if(!isset($id_usuario)) {
		mensajeSpan(['bg'=>'red','text'=> Language('incorrect-user-or-password', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]);
	}
	$pos['fecha_inicio_sesion'] = SCRIPTS->fecha_hora();
}

if($TIPO=='olvide_contrasena'){
	if(!isset($id_usuario)) {
		mensajeSpan(['bg'=>'red','text'=> Language('incorrect-user-or-email', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]);
	}
}


#PROCESA ->>>>>>>>>>>>>>>
$guardar = '';
$guardar_ini = "<?php #". SCRIPTS->fecha_hora()."\n";


if($TIPO=='registrar'){
	if(!isset($usu)){ $usu_idr = 1; $guardar .= $guardar_ini; } else {
		foreach ($usu as $key => $value) {
			if(strtolower($pos['usuario']) == strtolower($value['usuario'])){
				if($value['estado']=='publico'){
					mensajeSpan(['bg'=>'red','text'=> Language('user-already-in-use', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]); break;
				} else {
					mensajeSpan(['bg'=>'red','text'=> Language('selected-user-suspended-or-deleted', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]); break;
				}
			}
			if($pos['email'] == $value['email']){
				if($value['estado']=='publico'){
					mensajeSpan(['bg'=>'red','text'=> Language('email-already-in-use', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]); break;
				} else {
					mensajeSpan(['bg'=>'red','text'=> Language('selected-email-suspended-or-deleted', 'auth'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}",'tmpForm'=>$pos]); break;
				}
			}
		}
		$usu_idr = count($usu)+1;
	}
}

if($TIPO=='registrar'){
	$pos['id'] = $usu_idr;
	$pos['estado'] = 'publico';
	$pos['rol'] = isset($key_rol_key) ? $key_rol_key : 'Usuario';
	$pos['fecha_registrado'] = SCRIPTS->fecha_hora();
}

if($TIPO=='registrar'){
	$guardar .= str_replace('?>', '', file_get_contents($Web['directorio'].AppDatabase('usuarios/usuarios')));
	$guardar .= '$usu['.$usu_idr.'] = [';
	unset($pos['contrasena_confirmar']);
	$pos['contrasena'] = md5($pos['contrasena']);
	foreach ($pos as $key => $value) {
		if($key=='id'){ $guardar .= "'$key' => $value,"; } else { $guardar .= "'$key' => '$value',"; }
	}
}

if($TIPO=='registrar'){
	$guardar .= "];\n?>";

	file_put_contents($Web['directorio'].AppDatabase('usuarios/usuarios'), $guardar);

	$guardar = '<?php # ' . SCRIPTS->fecha_hora() .' -> '. $usu_idr."\n";
	$guardar .= '$Web'." = ['directorio'=>'../','ruta'=>'p/".$pos['usuario'].".php'];\n";
	$guardar .= "require_once ".'$Web'."['directorio'].'app/control/control.php';\n?>";
	file_put_contents($Web['directorio'].'p/'.$pos['usuario'].'.php', $guardar);
}

if($TIPO=='iniciar' || $TIPO=='cambiar_contrasena' || $TIPO=='configuracion'){
	if(!file_exists($Web['directorio'].AppDatabase('usuarios/usuarios_extras'))){
		file_put_contents($Web['directorio'].AppDatabase('usuarios/usuarios_extras'), $guardar_ini);
	}

	$guardar .= str_replace('?>', '', file_get_contents($Web['directorio'].AppDatabase('usuarios/usuarios_extras')));
}

if($TIPO=='iniciar'){
	$guardar .= '$usu'."[$id_usuario]['fecha_inicio_sesion'] = '".SCRIPTS->fecha_hora()."';\n";
}

if($TIPO=='iniciar'){
	file_put_contents($Web['directorio'].AppDatabase('usuarios/usuarios_extras'), $guardar);
}

if($TIPO=='cambiar_contrasena'){
	$guardar .= '$'."usu[{$_SESSION['id']}]['contrasena'] = '{$pos['nueva_contrasena']}';\n";
	$guardar .= '$'."usu[{$_SESSION['id']}]['fecha_contrasena_modificada'] = '". SCRIPTS->fecha_hora() ."';";
}


if($TIPO=='configuracion'){
	if($_POST['tipo']=='eliminar_cuenta'){
		$guardar .= '$usu['.$_SESSION['id']."]['eliminacion']=[";
		foreach ($pos as $key => $value) {
			$guardar .= "'$key'=>'$value',";
		}
		$guardar .= "];\n";
		$guardar .= '$usu['.$_SESSION['id']."]['estado']='eliminado'; ";
	} else {
		foreach ($pos as $key => $value) {
			$guardar .= '$usu['.$_SESSION['id']."]['$key']='$value'; ";
		}
	}
}

if($TIPO=='cambiar_contrasena' || $TIPO=='configuracion'){
	$guardar .= "\n?>";
	file_put_contents($Web['directorio'].AppDatabase('usuarios/usuarios_extras'), $guardar);
}


if($TIPO!='registrar' && $TIPO!='cambiar_contrasena' && $TIPO != 'configuracion'){
	$_SESSION['id'] = $id_usuario; $_SESSION['rol']=$usu[$id_usuario]['rol'];
}


# DIRECCIONES EXITO
if($TIPO=='registrar'){
	mensajeSpan(['bg'=>'green','text'=> Language('user-registered-success', 'auth'),'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}",'tmpForm'=>['usuario'=>$pos['usuario']]]);
}

if($TIPO=='iniciar'){
	mensajeSpan(['bg'=>'green','text'=> Language('welcome-back', 'auth'),'ruta'=>"{$Web['directorio']}p/{$usu[$id_usuario]['usuario']}{$Web['config']['php']}"]);
}
if($TIPO=='cambiar_contrasena'){
	mensajeSpan(['bg'=>'green','text'=> Language('password-changed-success', 'auth'),'ruta'=>"{$Web['directorio']}p/{$usu[$_SESSION['id']]['usuario']}{$Web['config']['php']}"]);
}
if($TIPO=='olvide_contrasena'){
	$_SESSION['cambiar_contrasena'] = true;
	mensajeSpan(['bg'=>'green','text'=> Language('want-to-change-password', 'auth'),'ruta'=>"{$Web['directorio']}p/{$usu[$id_usuario]['usuario']}{$Web['config']['php']}"]);
}

if($TIPO=='configuracion'){
	mensajeSpan(['bg'=>'green','text'=> Language('data-save'),'ruta'=>"{$Web['directorio']}auth/{$DIRECCION}"]);
}