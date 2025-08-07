<?php # CERRAR SESIÓN
if(isset($_GET['cerrar-sesion']) && $_GET['cerrar-sesion'] === "true" && isset($_SESSION['id'])){
	unset($_SESSION['id']); unset($_SESSION['rol']); unset($_SESSION['cambiar_contrasena']);
	Daamper::$sendAlert->Success(Language('farewell', 'alert'), "{$Web['directorio']}auth/login{$Web['config']['php']}");
}
# TEMA
if (isset($_GET['tema']) && !empty($_GET['tema'])) {
    if (file_exists($Web['directorio'] . Daamper::cssPath('template/daamper/theme/'.Daamper::$scripts->normalizar2($_GET['tema'])))) {
        $_SESSION['tmp']['tema'] = Daamper::$scripts->normalizar2($_GET['tema']);
    }
}

# IDIOMAS
if (isset($_GET['language']) && !empty($_GET['language'])) {
    if (isset(Daamper::$data->Config('language')['global']['languages-options'][htmlspecialchars($_GET['language'])])) {
        $_SESSION['tmp']['language'] = htmlspecialchars($_GET['language']);
    }
}