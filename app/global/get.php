<?php # CERRAR SESIÓN
if(isset($_GET['cerrar-sesion']) && isset($_SESSION['id'])){
	unset($_SESSION['id']); unset($_SESSION['rol']); unset($_SESSION['cambiar_contrasena']);
	mensajeSpan(['bg'=>'green',
		'text'=> Language('farewell', 'alert'),
		'ruta'=>"{$Web['directorio']}auth/iniciar{$Web['config']['php']}"
	]);
}
# TEMA
if (isset($_GET['tema']) && !empty($_GET['tema'])) {
    if (file_exists($Web['directorio'] . AssetsCss('theme/'.SCRIPTS->normalizar2($_GET['tema'])))) {
        $_SESSION['tmp']['tema'] = SCRIPTS->normalizar2($_GET['tema']);
    }
}

# IDIOMAS
if (isset($_GET['language']) && !empty($_GET['language'])) {
    if (isset(Database('config/language')['global']['languages-options'][htmlspecialchars($_GET['language'])])) {
        $_SESSION['tmp']['language'] = htmlspecialchars($_GET['language']);
    }
}