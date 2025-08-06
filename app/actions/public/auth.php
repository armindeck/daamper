<?php # MOD: 24/12/2024 | 24/03/2025 / 17/05/2025
$Web = ['directorio' => '../', 'ruta' => 'process/auth.php'];
if (isset($_SESSION['tmpForm'])) {
	unset($_SESSION['tmpForm']);
}
$list['procesa'] = ['iniciar', 'registrar', 'olvide_contrasena', 'cambiar_contrasena', 'no_cambiar_contrasena', 'configuracion'];
foreach ($list['procesa'] as $key => $value) {
	if (isset($_POST[$value]) && !empty($_POST[$value])) {
		$TIPO = $value;
		break;
	}
}
require_once $Web['directorio'] . 'app/controller/admin.php';

if (file_exists(Daamper::$data->UserRoute()) && empty(Daamper::$data->User())) { unlink(Daamper::$data->UserRoute()); }
if (!file_exists(Daamper::$data->UserRoute()) && file_exists(Daamper::$data->UserRoute(true))) { unlink(Daamper::$data->UserRoute(true)); }

if (!isset($TIPO)) {
	Daamper::$sendAlert->Warning(Language('no-access-file', 'auth'), "{$Web['directorio']}auth/login{$Web['config']['php']}");
}

$DIRECCION = $TIPO . $Web['config']['php'];
if (in_array($DIRECCION, ['olvide_contrasena', 'cambiar_contrasena'])) {
	$DIRECCION = str_replace('_', '-', $DIRECCION);
}

if (!isset($_POST['resultado']) || !isset($_POST['resultado_verificar'])) {
	Daamper::$sendAlert->Error(Language('do-not-modify-hidden-fields', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}");
}

if ($TIPO == 'iniciar') {
	$list['datos_procesa'] = ['usuario', 'contrasena'];
	$DIRECCION = 'login' . $Web['config']['php'];
}

if ($TIPO == 'registrar') {
	$list['datos_procesa'] = ['nombre', 'usuario', 'email', 'contrasena', 'contrasena_confirmar'];
	$DIRECCION = 'register' . $Web['config']['php'];
}

if ($TIPO == 'olvide_contrasena') {
	$list['datos_procesa'] = ['user-or-email', 'pin'];
	$DIRECCION = 'forgot-password' . $Web['config']['php'];
}

if ($TIPO == 'cambiar_contrasena') {
	if (!isset($_SESSION['cambiar_contrasena'])) {
		$list['datos_procesa'] = ['contrasena', 'nueva_contrasena', 'nueva_contrasena_confirmar'];
	} else {
		$list['datos_procesa'] = ['nueva_contrasena', 'nueva_contrasena_confirmar'];
	}
	$DIRECCION = 'change-password' . $Web['config']['php'];
}

if ($TIPO == 'no_cambiar_contrasena') {
	$list['datos_procesa'] = ['no_cambiar_contrasena'];
	$DIRECCION = 'login' . $Web['config']['php'];
}

if ($TIPO == 'configuracion') {
	if (isset($_POST['tipo'])) {
		switch ($_POST['tipo']) {
			case 'actualizar_datos_configuracion':
				$list['datos_procesa'] = ['nombre', 'descripcion', 'email', 'red_social_nombre', 'red_social_enlace', 'contrasena'];
				$DIRECCION = 'config' . $Web['config']['php'] . '?up=update-data';
				break;
			case 'actualizar_datos_configuracion_pin':
				$list['datos_procesa'] = ['contrasena'];
				$DIRECCION = 'config' . $Web['config']['php'] . '?up=pin';
				break;
			case 'actualizar_datos_avatar':
				$list['datos_procesa'] = ['contrasena'];
				$DIRECCION = 'config' . $Web['config']['php'] . '?up=change-avatar';
				break;
			case 'eliminar_cuenta':
				$list['datos_procesa'] = ['motivos', 'confirmar', 'motivos_texto', 'contrasena'];
				$DIRECCION = 'config' . $Web['config']['php'] . '?up=delete-account';
				break;
			default:
				Daamper::$sendAlert->Error(Language('do-not-modify-hidden-fields', 'auth'), "{$Web['directorio']}auth/config" . $Web['config']['php']);
				break;
		}
	} else {
		Daamper::$sendAlert->Error(Language('something-went-wrong', 'auth'), "{$Web['directorio']}auth/config" . $Web['config']['php']);
	}
}


foreach ($list['datos_procesa'] as $key => $value) {
	if ($value == 'usuario') {
		$pos[$value] = isset($_POST[$value]) ? Daamper::$scripts->sinEnes(Daamper::$scripts->sinAcentos(Daamper::$scripts->sinEspacios(Daamper::$scripts->darFormatoNoSimbolos(Daamper::$scripts->normalizar2($_POST[$value]))))) : '';
	} else {
		$pos[$value] = isset($_POST[$value]) ? Daamper::$scripts->normalizar2($_POST[$value]) : '';
	}
}

$list['datos_procesa_verificar'] = ['resultado', 'resultado_verificar'];

if (Daamper::$scripts->SimpleToken(Daamper::$scripts->normalizar2($_POST['resultado'])) != Daamper::$scripts->normalizar2($_POST['resultado_verificar'])) {
	if ($TIPO == 'no_cambiar_contrasena') {
		$TIPO = 'cambiar_contrasena';
	}
	Daamper::$sendAlert->Error(Language('incorrect-sum', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
}

if ($TIPO == 'no_cambiar_contrasena') {
	if (isset($_SESSION['id'])) {
		unset($_SESSION['cambiar_contrasena']);
		Daamper::$sendAlert->Error(Language('recommend-password-change', 'auth'), "{$Web['directorio']}p/".(Daamper::$data->User()[$_SESSION["id"]]["usuario"])."{$Web['config']['php']}");
	}
}

foreach ($list['datos_procesa'] as $key => $value) {
	if (!isset($_POST[$value])) {
		Daamper::$sendAlert->Error(Language('fill-required-fields', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
		break;
	}
}

if ($TIPO == 'iniciar') {
	$verificar = strlen($pos['usuario']) > 3 && strlen($pos['usuario']) < 21 &&
		strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51;
}

if ($TIPO == 'registrar') {
	$verificar = strlen($pos['usuario']) > 3 && strlen($pos['usuario']) < 21 &&
		strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51 &&
		strlen($pos['contrasena_confirmar']) > 7 && strlen($pos['contrasena_confirmar']) < 51 &&
		strlen($pos['nombre']) > 3 && strlen($pos['nombre']) < 51 &&
		strlen($pos['email']) > 3 && strlen($pos['email']) < 51 &&
		filter_var($pos['email'], FILTER_VALIDATE_EMAIL);
}

if ($TIPO == 'configuracion') {

	if ($_POST['tipo'] == 'actualizar_datos_configuracion') {
		$verificar = strlen($pos['descripcion']) > 3 && strlen($pos['descripcion']) < 51 &&
			strlen($pos['red_social_nombre']) > 0 && strlen($pos['red_social_nombre']) < 51 &&
			strlen($pos['red_social_enlace']) > 4 && strlen($pos['red_social_enlace']) < 101 &&
			filter_var($pos['red_social_enlace'], FILTER_VALIDATE_URL) &&
			strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51 &&
			strlen($pos['nombre']) > 3 && strlen($pos['nombre']) < 51 &&
			strlen($pos['email']) > 3 && strlen($pos['email']) < 51 &&
			filter_var($pos['email'], FILTER_VALIDATE_EMAIL);
	}

	if ($_POST['tipo'] == 'actualizar_datos_avatar') {
		$verificar =
			strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51;
	}

	if ($_POST['tipo'] == 'actualizar_datos_configuracion_pin') {
		$verificar =
			strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51;
	}

	if ($_POST['tipo'] == 'eliminar_cuenta') {
		$verificar = strlen($pos['motivos']) > 3 && strlen($pos['motivos']) < 51 &&
			strlen($pos['confirmar']) > 3 && strlen($pos['confirmar']) < 51 &&
			strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51;
	}
}

if ($TIPO == 'olvide_contrasena') {
	$verificar =
		strlen($pos['user-or-email']) > 3 && strlen($pos['user-or-email']) < 51 &&
		strlen($pos['pin']) > 3 && strlen($pos['pin']) < 51;
}

if ($TIPO == 'cambiar_contrasena') {
	$verificar = true;
	if (!isset($_SESSION['cambiar_contrasena'])) {
		$verificar = strlen($pos['contrasena']) > 7 && strlen($pos['contrasena']) < 51;
	}
	if ($verificar) {
		$verificar = strlen($pos['nueva_contrasena']) > 7 && strlen($pos['nueva_contrasena']) < 51 &&
			strlen($pos['nueva_contrasena_confirmar']) > 7 && strlen($pos['nueva_contrasena_confirmar']) < 51;
	}
}


if (!$verificar) {
	Daamper::$sendAlert->Error(Language('fill-fields-with-data', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
}

if ($TIPO == 'registrar') {
	if ($pos['contrasena'] != $pos['contrasena_confirmar']) {
		Daamper::$sendAlert->Error(Language('password-mismatch', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
	}
}

if ($TIPO == 'cambiar_contrasena') {
	if ($pos['nueva_contrasena'] != $pos['nueva_contrasena_confirmar']) {
		Daamper::$sendAlert->Error(Language('password-mismatch', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}");
	}
}

Daamper::$scripts->CrearCarpetas("database/user/");
Daamper::$scripts->CrearCarpetas("p/");

if (file_exists(Daamper::$data->UserRoute())) {
	$usu = Daamper::$data->Read("user/user");
	if (file_exists(Daamper::$data->UserRoute(true)) && !empty($usu)) {
		$usu = Daamper::$scripts->UnirArrays($usu, Daamper::$data->Read("user/extras"));
	}
}

if ($TIPO != 'registrar') {
	if (!isset($usu)) {
		Daamper::$sendAlert->Error(Language('no-users-or-database', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
	}
}

if ($TIPO == 'iniciar') {
	foreach ($usu as $key => $value) {
		if (strtolower($pos['usuario']) == strtolower($value['usuario']) && md5($pos['contrasena']) == $value['contrasena']) {
			if ($value['estado'] != 'publico') {
				Daamper::$sendAlert->Error(Language('profile-suspended-or-deleted', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
			}
			$id_usuario = $value['id'];
			break;
		}
	}
}

if ($TIPO == 'configuracion') {
	if ($_POST['tipo'] == 'actualizar_datos_configuracion') {
		foreach ($usu as $key => $value) {
			if ($pos['email'] == $value['email']) {
				if ($_SESSION['id'] != $value['id']) {
					Daamper::$sendAlert->Error(Language('email-already-used', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
				}
			}
		}
	}
}

if ($TIPO == 'olvide_contrasena') {
	$is_email = filter_var($pos['user-or-email'], FILTER_VALIDATE_EMAIL);
	foreach ($usu as $key => $value) {
		if (strtolower($pos["user-or-email"]) == strtolower($value[$is_email ? "email" : "usuario"])){
			if ($value['estado'] == 'publico') {
				$id_usuario = $value['id'];
			}
			break;
		}
	}
}


if ($TIPO == 'cambiar_contrasena') {
	if (!isset($_SESSION['cambiar_contrasena'])) {
		if (md5($pos['contrasena']) != $usu[$_SESSION['id']]['contrasena']) {
			Daamper::$sendAlert->Error(Language('incorrect-password', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}");
		}
	}
	if (md5($pos['nueva_contrasena']) == $usu[$_SESSION['id']]['contrasena']) {
		Daamper::$sendAlert->Error(Language('use-another-password', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}");
	}
	$pos['nueva_contrasena'] = md5($pos['nueva_contrasena']);
}


if ($TIPO == 'configuracion') {
	if (md5($pos['contrasena']) != $usu[$_SESSION['id']]['contrasena']) {
		Daamper::$sendAlert->Error(Language('incorrect-password', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
	} else {
		unset($pos['contrasena']);
	}

	if ($_POST['tipo'] == 'eliminar_cuenta') {
		if ($pos['confirmar'] != 'Si eliminar') {
			Daamper::$sendAlert->Error(Language('confirm-deletion', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
		}

		unset($pos['confirmar']);
		$pos['fecha_eliminado'] = Daamper::$scripts->fecha_hora();
	} else {
		$pos['fecha_modificado'] = Daamper::$scripts->fecha_hora();
	}
}


if ($TIPO == 'iniciar') {
	if (!isset($id_usuario)) {
		Daamper::$sendAlert->Error(Language('incorrect-user-or-password', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
	}
	$pos['fecha_inicio_sesion'] = Daamper::$scripts->fecha_hora();
}

if ($TIPO == 'olvide_contrasena') {
	if (!isset($id_usuario)) {
		Daamper::$sendAlert->Error(Language('incorrect-user-or-email', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
	}
	if ($pos["pin"] != $usu[$id_usuario]["pin"]) {
		Daamper::$sendAlert->Error(Language('pin-incorrect', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
	}
}


#PROCESA ->>>>>>>>>>>>>>>

if ($TIPO == 'registrar') {
	if (!isset($usu)) {
		$usu_idr = 1;
	} else {
		foreach ($usu as $key => $value) {
			if (strtolower($pos['usuario']) == strtolower($value['usuario'])) {
				if ($value['estado'] == 'publico') {
					Daamper::$sendAlert->Error(Language('user-already-in-use', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
					break;
				} else {
					Daamper::$sendAlert->Error(Language('selected-user-suspended-or-deleted', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
					break;
				}
			}
			if ($pos['email'] == $value['email']) {
				if ($value['estado'] == 'publico') {
					Daamper::$sendAlert->Error(Language('email-already-in-use', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
					break;
				} else {
					Daamper::$sendAlert->Error(Language('selected-email-suspended-or-deleted', 'auth'), "{$Web['directorio']}auth/{$DIRECCION}", $pos);
					break;
				}
			}
		}
		$usu_idr = count($usu) + 1;
	}
}

if ($TIPO == 'registrar') {
	$pos['id'] = $usu_idr;
	$pos['estado'] = 'publico';
	$pos['rol'] = 'Usuario';
	$pos['fecha_registrado'] = Daamper::$scripts->fecha_hora();
	unset($pos['contrasena_confirmar']);
	$pos['contrasena'] = md5($pos['contrasena']);
	$pos['pin'] = Daamper::$scripts->GenerarPin();
}


if ($TIPO == 'registrar') {
	Daamper::$data->InsertUser($pos);
	Daamper::$data->CreateEntry("p/" . $pos['usuario'], "../");
}

if ($TIPO == 'iniciar' || $TIPO == 'cambiar_contrasena' || $TIPO == 'configuracion') {
	if (!file_exists(Daamper::$data->UserRoute(true))) { Daamper::$data->Save(Daamper::$data->UserRoute(true, false), []); }

	$leer = Daamper::$data->User("extras") ?? [];
}

if (in_array($TIPO, ['iniciar', 'registrar'])) {
	$leer[($TIPO == "iniciar" ? $id_usuario : $pos['id'])]['fecha_inicio_sesion'] = Daamper::$scripts->fecha_hora();
	Daamper::$data->UpdateUser($leer, true);
}

if ($TIPO == 'cambiar_contrasena') {
	$leer[$_SESSION['id']]['contrasena'] = $pos['nueva_contrasena'];
	$leer[$_SESSION['id']]['fecha_contrasena_modificada'] = Daamper::$scripts->fecha_hora();
}


if ($TIPO == 'configuracion') {
	if ($_POST['tipo'] == 'actualizar_datos_avatar') {
		$tipo_de_seccion = "auth";
		require __DIR__ . '/../components/upload-image.php';
	}
	$POS = [];
	if ($_POST['tipo'] == 'eliminar_cuenta') {
		foreach ($pos as $key => $value) {
			$POS['eliminacion'][$key] = $value;
		}
		$POS['estado'] = 'eliminado';
	} elseif ($_POST['tipo'] != "actualizar_datos_configuracion_pin") {
		foreach ($pos as $key => $value) {
			if (!isset($usu[$_SESSION["id"]][$key])) {
				$POS[$key] = $value;
			} else {
				if ($usu[$_SESSION["id"]][$key] != $value) {
					$POS[$key] = $value;
				}
			}
		}
	} else {
		$POS["pin"] = Daamper::$scripts->GenerarPin();
	}
	$leer = Daamper::$scripts->UnirArrays(Daamper::$data->User("extras"), [$_SESSION["id"] => $POS]);
}

if (in_array($TIPO, ['olvide_contrasena'])) {
	$POS = [];
	$POS['fechas'][Daamper::$scripts->fecha_hora()] = "Forgot password";
	$POS['fecha_inicio_sesion'] = Daamper::$scripts->fecha_hora();
	$leer = Daamper::$scripts->UnirArrays(Daamper::$data->User("extras"), [$id_usuario => $POS]);
}

if (in_array($TIPO, ['cambiar_contrasena', 'configuracion', 'olvide_contrasena'])) {
	Daamper::$data->UpdateUser($leer, true);
}

if (!in_array($TIPO, ['cambiar_contrasena', 'configuracion'])) {
	$_SESSION['id'] = $TIPO == "registrar" ? $pos['id'] : $id_usuario;
	if($TIPO == "registrar"){
		$usu = Daamper::$data->UserAll();
	}
	$_SESSION['rol'] = $usu[($TIPO == "registrar" ? $pos['id'] : $id_usuario)]['rol'];
}

# DIRECCIONES EXITO

if (in_array($TIPO, ['iniciar', 'registrar'])) {
	Daamper::$sendAlert->Success(Language($TIPO == 'iniciar' ? 'welcome-back' : 'user-registered-success', 'auth'), "{$Web['directorio']}p/".($usu[($TIPO == 'iniciar' ? $id_usuario : $pos["id"])]['usuario'])."{$Web['config']['php']}");
}

if ($TIPO == 'cambiar_contrasena') {
	if(isset($_SESSION['cambiar_contrasena'])){ unset($_SESSION['cambiar_contrasena']); }
	Daamper::$sendAlert->Success(Language('password-changed-success', 'auth'), "{$Web['directorio']}p/{$usu[$_SESSION['id']]['usuario']}{$Web['config']['php']}");
}
if ($TIPO == 'olvide_contrasena') {
	$_SESSION['cambiar_contrasena'] = true;
	Daamper::$sendAlert->Success(Language('want-to-change-password', 'auth'), "{$Web['directorio']}p/{$usu[$id_usuario]['usuario']}{$Web['config']['php']}");
}

if ($TIPO == 'configuracion') {
	Daamper::$sendAlert->Success(Language('data-save'), "{$Web['directorio']}auth/{$DIRECCION}");
}
